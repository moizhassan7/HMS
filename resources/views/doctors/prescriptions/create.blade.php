@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Write New Prescription</h2>
        <a href="{{ route('prescriptions.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
            Back to List
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('prescriptions.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-6">
        @csrf
        
        <!-- Patient Info -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Patient Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="patient_id" class="block text-gray-700 text-sm font-bold mb-2">Select Patient:</label>
                <select name="patient_id" id="patient_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->mr_number }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="visit_date" class="block text-gray-700 text-sm font-bold mb-2">Visit Date:</label>
                <input type="date" name="visit_date" id="visit_date" value="{{ date('Y-m-d') }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
        </div>

        <!-- Medicines -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 mt-8">Medicines</h3>
        <div id="medicines-container" class="space-y-4 mb-4">
            <!-- Dynamic Rows will appear here -->
        </div>
        <button type="button" onclick="addMedicineRow()" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow">
            + Add Medicine
        </button>

        <!-- Tests -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Pathology Tests</h3>
                <div class="h-48 overflow-y-auto border rounded p-2 bg-gray-50">
                    @foreach($pathologyTests as $test)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="pathology_tests[]" value="{{ $test->id }}" id="path_test_{{ $test->id }}" class="mr-2">
                            <label for="path_test_{{ $test->id }}" class="text-gray-700">{{ $test->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Radiology Procedures</h3>
                <div class="h-48 overflow-y-auto border rounded p-2 bg-gray-50">
                    @foreach($radiologyProcedures as $proc)
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="radiology_tests[]" value="{{ $proc->id }}" id="rad_proc_{{ $proc->id }}" class="mr-2">
                            <label for="rad_proc_{{ $proc->id }}" class="text-gray-700">{{ $proc->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Notes -->
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2 mt-8">Clinical Notes</h3>
        <div class="mb-6">
            <textarea name="notes" rows="4" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter diagnosis, complaints, or other notes..."></textarea>
        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                Save Prescription
            </button>
        </div>
    </form>
</div>

<script>
    let medicineIndex = 0;
    const medicines = @json($medicines);

    function addMedicineRow() {
        const container = document.getElementById('medicines-container');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-1 md:grid-cols-5 gap-4 items-end bg-gray-50 p-4 rounded border';
        
        let options = '<option value="">Select Medicine</option>';
        medicines.forEach(med => {
            options += `<option value="${med.id}">${med.name} (${med.generic_name})</option>`;
        });

        row.innerHTML = `
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-xs font-bold mb-1">Medicine</label>
                <select name="medicines[${medicineIndex}][medicine_id]" class="shadow border rounded w-full py-2 px-3 text-sm" required>
                    ${options}
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-xs font-bold mb-1">Dosage</label>
                <input type="text" name="medicines[${medicineIndex}][dosage]" class="shadow border rounded w-full py-2 px-3 text-sm" placeholder="e.g. 1-0-1" required>
            </div>
            <div>
                <label class="block text-gray-700 text-xs font-bold mb-1">Duration</label>
                <input type="text" name="medicines[${medicineIndex}][duration]" class="shadow border rounded w-full py-2 px-3 text-sm" placeholder="e.g. 5 days" required>
            </div>
            <div class="flex items-center">
                 <button type="button" onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700 font-bold ml-2">
                    &times; Remove
                </button>
            </div>
            <div class="md:col-span-5">
                 <label class="block text-gray-700 text-xs font-bold mb-1">Instructions</label>
                 <input type="text" name="medicines[${medicineIndex}][instruction]" class="shadow border rounded w-full py-2 px-3 text-sm" placeholder="e.g. After meal">
            </div>
        `;

        container.appendChild(row);
        medicineIndex++;
    }

    // Add one row by default
    document.addEventListener('DOMContentLoaded', function() {
        addMedicineRow();
    });
</script>
@endsection
