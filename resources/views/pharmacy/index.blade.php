@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Pharmacy Inventory</h2>
        <div class="flex space-x-4">
            <a href="{{ route('pharmacy.medicines') }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                Add Medicine
            </a>
            <a href="{{ route('pharmacy.dispense_index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
                Dispense Medicines
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Medicine Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Generic Name
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Batch No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Expiry Date
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Quantity Available
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 font-bold whitespace-no-wrap">{{ $stock->medicine->name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $stock->medicine->generic_name }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $stock->batch_number }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap {{ $stock->expiry_date < now() ? 'text-red-600 font-bold' : '' }}">
                                    {{ $stock->expiry_date->format('Y-m-d') }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold {{ $stock->quantity_available < 10 ? 'text-red-900' : 'text-green-900' }} leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 {{ $stock->quantity_available < 10 ? 'bg-red-200' : 'bg-green-200' }} opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $stock->quantity_available }}</span>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
            {{ $stocks->links() }}
        </div>
    </div>
</div>
@endsection
