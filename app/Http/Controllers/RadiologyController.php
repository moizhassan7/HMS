<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrescriptionTest;
use App\Models\RadiologyResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RadiologyController extends Controller
{
    /**
     * Display a listing of pending radiology requests.
     */
    public function index()
    {
        $requests = PrescriptionTest::where('type', 'radiology')
            ->where('status', 'pending')
            ->with(['prescription.patient', 'prescription.doctor'])
            ->orderBy('created_at', 'asc')
            ->paginate(15);
            
        // Note: We need to access the procedure name. 
        // In PrescriptionTest model we have getTestDetailsAttribute accessor but it might not be eager loadable easily.
        // We will handle it in the view or append it.
        
        return view('radiology.index', compact('requests'));
    }

    /**
     * Show the form for entering results.
     */
    public function enterResults($id)
    {
        $testRequest = PrescriptionTest::with(['prescription.patient', 'prescription.doctor'])->findOrFail($id);
        
        if ($testRequest->type !== 'radiology') {
            abort(404);
        }

        return view('radiology.enter_results', compact('testRequest'));
    }

    /**
     * Store the radiology result.
     */
    public function storeResults(Request $request, $id)
    {
        $testRequest = PrescriptionTest::findOrFail($id);

        $request->validate([
            'report_text' => 'required|string',
            'image_file' => 'nullable|image|max:10240', // 10MB max
        ]);

        DB::beginTransaction();

        try {
            $imagePath = null;
            if ($request->hasFile('image_file')) {
                $imagePath = $request->file('image_file')->store('radiology_images', 'public');
            }

            RadiologyResult::create([
                'prescription_test_id' => $testRequest->id,
                'radiologist_id' => Auth::id() ?? 1, // Fallback to 1 if not logged in
                'report_text' => $request->report_text,
                'image_path' => $imagePath,
                'completed_at' => now(),
            ]);

            $testRequest->status = 'completed';
            $testRequest->save();

            DB::commit();

            return redirect()->route('radiology.index')->with('success', 'Radiology result submitted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving result: ' . $e->getMessage());
        }
    }
}
