<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Location;
use App\Models\PharmacyStock;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function add(Medicine $medicine = null)
    {
        $medicines = Medicine::with(['category', 'location', 'stocks'])->get(); // Eager load relationships
        $categories = Category::all(); // Fetch all categories for dropdown
        $locations = Location::all(); // Fetch all locations for dropdown

        return view('pharmacy.add_medicine', compact('medicines', 'medicine', 'categories', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name',
            'description' => 'nullable|string',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'min_stock_level' => 'required|integer|min:0',
            'batch_number' => 'required|string|max:255',
            'quantity_available' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        // Create the medicine
        $medicine = new Medicine();
        $medicine->name = $request->input('name');
        $medicine->description = $request->input('description');
        $medicine->generic_name = $request->input('generic_name');
        $medicine->manufacturer = $request->input('manufacturer');
        $medicine->category_id = $request->input('category_id');
        $medicine->location_id = $request->input('location_id');
        $medicine->min_stock_level = $request->input('min_stock_level');
        $medicine->save();

        // Create initial stock
        $stock = new PharmacyStock();
        $stock->medicine_id = $medicine->id;
        $stock->medicine_name = $medicine->name;
        $stock->batch_number = $request->input('batch_number');
        $stock->quantity_available = $request->input('quantity_available');
        $stock->expiry_date = $request->input('expiry_date');
        $stock->price_per_unit = $request->input('price_per_unit');
        $stock->save();

        return redirect()->route('pharmacy.medicines')->with('success', 'Medicine added successfully!');
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
            'description' => 'nullable|string',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'min_stock_level' => 'required|integer|min:0',
        ]);

        $medicine->name = $request->input('name');
        $medicine->description = $request->input('description');
        $medicine->generic_name = $request->input('generic_name');
        $medicine->manufacturer = $request->input('manufacturer');
        $medicine->category_id = $request->input('category_id');
        $medicine->location_id = $request->input('location_id');
        $medicine->min_stock_level = $request->input('min_stock_level');
        $medicine->save();

        return redirect()->route('pharmacy.medicines')->with('success', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        // Check if medicine has stocks
        if ($medicine->stocks()->exists()) {
            return redirect()->route('pharmacy.medicines')->with('error', 'Cannot delete medicine with existing stock!');
        }

        $medicine->delete();
        return redirect()->route('pharmacy.medicines')->with('success', 'Medicine deleted successfully!');
    }
}
