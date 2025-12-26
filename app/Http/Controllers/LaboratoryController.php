<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Test;
use App\Models\LaboratoryPatient;
use Illuminate\Validation\ValidationException;

class LaboratoryController extends Controller
{
    /**
     * Display the laboratory patient registration form with dynamic data.
     *
     * @return \Illuminate\View\View
     */
    public function showPatientRegistration()
    {
        $doctors = Doctor::all();
        $tests = Test::all();

        return view('laboratory.patient_registration', compact('doctors', 'tests'));
    }

    /**
     * Search for a patient by MR No.
     *
     * @param  string  $mr_no
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatientByMrNo($mr_no)
    {
        $patient = Patient::where('mr_number', $mr_no)->first();
        return response()->json($patient);
    }

    /**
     * Display pending pathology requests from prescriptions.
     */
    public function index()
    {
        return view('laboratory.index');
    }

    /**
     * Search for a patient and show pending pathology tests.
     */
    public function searchPatient(Request $request)
    {
        $mr_no = $request->input('mr_no');
        $patient = null;
        $pendingTests = collect();

        if ($mr_no) {
            $patient = \App\Models\Patient::where('mr_number', $mr_no)->first();

            if ($patient) {
                // Get pending pathology tests from prescriptions
                $pendingTests = \App\Models\PrescriptionTest::where('type', 'pathology')
                    ->where('status', 'pending')
                    ->whereHas('prescription', function($q) use ($patient) {
                        $q->where('patient_id', $patient->id);
                    })
                    ->with(['prescription.doctor', 'test'])
                    ->get();
            }
        }

        return view('laboratory.index', compact('patient', 'pendingTests', 'mr_no'));
    }

    /**
     * Show form for entering results for prescription-based tests.
     */
    public function enterPrescriptionTestResults($patient_id, $test_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $test = Test::findOrFail($test_id);

        // Get the prescription test record
        $prescriptionTest = PrescriptionTest::where('test_id', $test_id)
            ->whereHas('prescription', function($q) use ($patient_id) {
                $q->where('patient_id', $patient_id);
            })
            ->where('type', 'pathology')
            ->where('status', 'pending')
            ->firstOrFail();

        return view('laboratory.prescription_result_form', compact('patient', 'test', 'prescriptionTest'));
    }

    /**
     * Store results for prescription-based tests.
     */
    public function storePrescriptionTestResults(Request $request, $patient_id, $test_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $test = Test::findOrFail($test_id);

        $prescriptionTest = PrescriptionTest::where('test_id', $test_id)
            ->whereHas('prescription', function($q) use ($patient_id) {
                $q->where('patient_id', $patient_id);
            })
            ->where('type', 'pathology')
            ->where('status', 'pending')
            ->firstOrFail();

        $request->validate([
            'results' => 'required|array',
            'results.*' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->results as $particularId => $result) {
                TestResult::create([
                    'laboratory_patient_id' => null, // Since it's not from lab patient
                    'test_id' => $test_id,
                    'test_particular_id' => $particularId,
                    'result_value' => $result,
                    'prescription_test_id' => $prescriptionTest->id, // Add this field if needed
                ]);
            }

            $prescriptionTest->status = 'completed';
            $prescriptionTest->save();

            DB::commit();

            return redirect()->route('laboratory.index')->with('success', 'Test results saved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving results: ' . $e->getMessage());
        }
    }

    /**
     * Store a new patient registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeLabRegistration(Request $request)
    {
        try {
            // Validate the request data.
            $validatedData = $request->validate([
                'mr_no' => 'nullable|string|max:255',
                'patient_name' => 'required|string|max:255',
                'gender' => 'required|string|in:Male,Female,Other',
                'contact_no' => 'nullable|string|max:255',
                'age' => 'required|integer|min:0',
                'file_no' => 'nullable|string|max:255',
                'priority' => 'required|string|in:Routine,Urgent,STAT',
                'self_referred' => 'nullable|boolean',
                'refer_by_doctor_name' => 'nullable|string|max:255',
                'tests' => 'required|json', // Validate 'tests' as a JSON string
                'sub_total' => 'required|numeric',
                'discount' => 'nullable|numeric|min:0',
                'grand_total' => 'required|numeric',
                'paid_amount' => 'nullable|numeric|min:0',
                'due_amount' => 'required|numeric',
                'previous_due' => 'nullable|numeric|min:0',
            ]);

            // Decode the JSON string back into a PHP array
            $selectedTests = json_decode($validatedData['tests'], true);

            // Transform the `carry_out` string to a boolean for the database.
            $selectedTestsWithBoolean = collect($selectedTests)->map(function ($test) {
                $test['carry_out'] = filter_var($test['carry_out'], FILTER_VALIDATE_BOOLEAN);
                return $test;
            })->values()->all();

            // Create a new patient registration record.
            LaboratoryPatient::create([
                'mr_no' => $validatedData['mr_no'],
                'patient_name' => $validatedData['patient_name'],
                'gender' => $validatedData['gender'],
                'contact_no' => $validatedData['contact_no'],
                'age' => $validatedData['age'],
                'file_no' => $validatedData['file_no'],
                'priority' => $validatedData['priority'],
                'self_referred' => $request->has('self_referred'),
                'refer_by_doctor_name' => $validatedData['refer_by_doctor_name'],
                'selected_tests' => json_encode($selectedTestsWithBoolean),
                'sub_total' => $validatedData['sub_total'],
                'discount' => $validatedData['discount'],
                'grand_total' => $validatedData['grand_total'],
                'paid_amount' => $validatedData['paid_amount'],
                'due_amount' => $validatedData['due_amount'],
                'previous_due' => $validatedData['previous_due'],
            ]);

            return redirect()->route('laboratory.patient_registration')->with('success', 'Patient registration saved successfully!');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
    
}
