<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use App\Models\PrescriptionTest;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Test; // Pathology tests
use App\Models\RadiologyProcedure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Assuming the logged-in user is a doctor or admin. 
        // If doctor, maybe filter by doctor_id.
        // For now, let's show all for admin, and doctor's own for doctor.
        
        $query = Prescription::with(['patient', 'doctor']);
        
        // Simple role check simulation or usage of Auth::user()
        // If we had a direct link from User to Doctor:
        // $doctor = Auth::user()->doctor;
        // if($doctor) { $query->where('doctor_id', $doctor->id); }

        $prescriptions = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('doctors.prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::select('id', 'name', 'mr_number')->get();
        $medicines = Medicine::select('id', 'name', 'generic_name')->get();
        $pathologyTests = Test::select('id', 'name')->get();
        $radiologyProcedures = RadiologyProcedure::select('id', 'name')->get();

        return view('doctors.prescriptions.create', compact('patients', 'medicines', 'pathologyTests', 'radiologyProcedures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.duration' => 'required|string',
            'medicines.*.quantity' => 'required|integer|min:1',
            'pathology_tests' => 'nullable|array',
            'pathology_tests.*' => 'exists:tests,id',
            'radiology_tests' => 'nullable|array',
            'radiology_tests.*' => 'exists:radiology_procedures,id',
        ]);

        DB::beginTransaction();

        try {
            // Determine doctor_id. For now, hardcode or try to find from auth user.
            // If User has a doctor record linked via user_id (not seen in Doctor model, but let's assume Auth::id() for now if user is doctor)
            // Or passing it from form if admin is creating.
            // Let's assume the current user is a doctor.
            // Since Doctor model doesn't seem to have user_id, we might need to rely on a 'doctor_id' field in users or similar.
            // Workaround: If Auth user is linked to a doctor, use that.
            // For this implementation, I'll assume we pass doctor_id or use a dummy one if not linked.
            
            // FIXME: Logic to get actual doctor ID.
            // Check if 'doctors' table has 'user_id' or if 'users' table has 'doctor_id'.
            // Based on previous `ls`, `Doctor` model has no `user_id`. `User` model has no `doctor_id`.
            // However, `Doctor` has `email`. We can match email?
            // Or maybe the user IS the doctor.
            // Let's assume for now we pick the first doctor for demo if not found.
            
            $doctor = \App\Models\Doctor::first(); // Fallback
            if (Auth::check()) {
                 $d = \App\Models\Doctor::where('email', Auth::user()->email)->first();
                 if ($d) $doctor = $d;
            }

            $prescription = Prescription::create([
                'doctor_id' => $doctor ? $doctor->id : 1, // Fallback to 1
                'patient_id' => $request->patient_id,
                'visit_date' => $request->visit_date,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            if ($request->has('medicines')) {
                foreach ($request->medicines as $med) {
                    PrescriptionMedicine::create([
                        'prescription_id' => $prescription->id,
                        'medicine_id' => $med['medicine_id'],
                        'dosage' => $med['dosage'],
                        'duration' => $med['duration'],
                        'instruction' => $med['instruction'] ?? null,
                    ]);
                }
            }

            if ($request->has('pathology_tests')) {
                foreach ($request->pathology_tests as $testId) {
                    PrescriptionTest::create([
                        'prescription_id' => $prescription->id,
                        'test_id' => $testId,
                        'type' => 'pathology',
                        'status' => 'pending',
                    ]);
                }
            }

            if ($request->has('radiology_tests')) {
                foreach ($request->radiology_tests as $procId) {
                    PrescriptionTest::create([
                        'prescription_id' => $prescription->id,
                        'test_id' => $procId,
                        'type' => 'radiology',
                        'status' => 'pending',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating prescription: ' . $e->getMessage());
        }
    }
}
