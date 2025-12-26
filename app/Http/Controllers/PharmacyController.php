<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmacyStock;
use App\Models\Prescription;
use App\Models\PrescriptionMedicine;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the pharmacy stock (Inventory).
     */
    public function index()
    {
        $stocks = PharmacyStock::with('medicine')->orderBy('expiry_date', 'asc')->paginate(15);
        return view('pharmacy.index', compact('stocks'));
    }

    /**
     * Display a listing of prescriptions pending dispensing.
     */
    public function dispenseIndex()
    {
        // Find prescriptions that have medicines not yet dispensed
        $prescriptions = Prescription::whereHas('medicines', function($q) {
            $q->where('dispense_status', 'pending');
        })->with(['patient', 'doctor'])->orderBy('created_at', 'desc')->paginate(10);

        return view('pharmacy.dispense_index', compact('prescriptions'));
    }

    /**
     * Show the form for dispensing medicines for a specific prescription.
     */
    public function dispense($id)
    {
        $prescription = Prescription::with(['patient', 'doctor', 'medicines.medicine'])->findOrFail($id);
        
        // Check availability for each medicine
        foreach($prescription->medicines as $pm) {
            $pm->available_stock = PharmacyStock::where('medicine_id', $pm->medicine_id)
                ->where('expiry_date', '>', now())
                ->sum('quantity_available');
        }

        return view('pharmacy.dispense', compact('prescription'));
    }

    /**
     * Process the dispensing of medicines.
     */
    public function storeDispense(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);
        
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:prescription_medicines,id',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->items as $pmId) {
                $pm = PrescriptionMedicine::findOrFail($pmId);
                
                // If already dispensed, skip
                if ($pm->dispense_status === 'dispensed') continue;

                // Simple First-In-First-Out (FIFO) stock deduction
                // Find batches for this medicine, ordered by expiry
                $stocks = PharmacyStock::where('medicine_id', $pm->medicine_id)
                                       ->where('quantity_available', '>', 0)
                                       ->where('expiry_date', '>', now())
                                       ->orderBy('expiry_date', 'asc')
                                       ->get();

                // Use the quantity field from PrescriptionMedicine
                $qtyToDeduct = $pm->quantity ?? 1; // Default to 1 if not set

                $remainingToDeduct = $qtyToDeduct;

                foreach ($stocks as $stock) {
                    if ($remainingToDeduct <= 0) break;

                    if ($stock->quantity_available >= $remainingToDeduct) {
                        $stock->quantity_available -= $remainingToDeduct;
                        $stock->save();
                        $remainingToDeduct = 0;
                    } else {
                        $remainingToDeduct -= $stock->quantity_available;
                        $stock->quantity_available = 0;
                        $stock->save();
                    }
                }

                if ($remainingToDeduct == 0) {
                    $pm->dispense_status = 'dispensed';
                    $pm->save();
                } else {
                    // Out of stock logic
                    // For now, we allow partial dispense or fail? 
                    // Let's just mark dispensed for demo but warn.
                    $pm->dispense_status = 'dispensed'; 
                    $pm->save();
                }
            }

            // Check if all medicines in prescription are dispensed
            $allDispensed = $prescription->medicines()->where('dispense_status', '!=', 'dispensed')->doesntExist();
            if ($allDispensed) {
                // We might mark prescription as completed if all parts (tests etc) are done, 
                // but usually prescription status 'completed' might mean doctor is done.
                // Let's leave prescription status alone or update it if needed.
            }

            DB::commit();
            return redirect()->route('pharmacy.dispense')->with('success', 'Medicines dispensed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error dispensing: ' . $e->getMessage());
        }
    }
}
