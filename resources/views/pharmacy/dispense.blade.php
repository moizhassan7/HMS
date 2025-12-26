@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Dispense Medicines</h2>
        <a href="{{ route('pharmacy.dispense_index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
            Back to List
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 font-bold">Patient Name:</p>
                <p class="text-gray-900">{{ $prescription->patient->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">MR Number:</p>
                <p class="text-gray-900">{{ $prescription->patient->mr_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">Doctor:</p>
                <p class="text-gray-900">{{ $prescription->doctor->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">Date:</p>
                <p class="text-gray-900">{{ $prescription->visit_date }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('pharmacy.dispense.store', $prescription->id) }}" method="POST" class="bg-white rounded-xl shadow-lg p-6">
        @csrf
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Prescribed Medicines</h3>
        
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Select
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Medicine
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Dosage
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Duration
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Stock Available
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescription->medicines as $pm)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($pm->dispense_status === 'pending')
                                    <input type="checkbox" name="items[]" value="{{ $pm->id }}" class="form-checkbox h-5 w-5 text-blue-600" checked>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 font-bold whitespace-no-wrap">{{ $pm->medicine->name }}</p>
                                <p class="text-gray-600 text-xs">{{ $pm->medicine->generic_name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $pm->dosage }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $pm->duration }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="{{ $pm->available_stock > 0 ? 'text-green-600' : 'text-red-600 font-bold' }}">
                                    {{ $pm->available_stock }} units
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($pm->dispense_status === 'dispensed')
                                    <span class="text-green-600 font-bold">Dispensed</span>
                                @else
                                    <span class="text-orange-600 font-bold">Pending</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                Confirm Dispense
            </button>
        </div>
    </form>
</div>
@endsection
