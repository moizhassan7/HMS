@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Enter Radiology Results</h2>
        <a href="{{ route('radiology.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg shadow-md transition-colors duration-200">
            Back to List
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 font-bold">Patient Name:</p>
                <p class="text-gray-900">{{ $testRequest->prescription->patient->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">MR Number:</p>
                <p class="text-gray-900">{{ $testRequest->prescription->patient->mr_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">Procedure:</p>
                <p class="text-gray-900 text-xl">{{ $testRequest->test_details ? $testRequest->test_details->name : 'Unknown' }}</p>
            </div>
            <div>
                <p class="text-gray-600 font-bold">Requested By:</p>
                <p class="text-gray-900">{{ $testRequest->prescription->doctor->name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('radiology.store_results', $testRequest->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-lg p-6">
        @csrf
        
        <div class="mb-6">
            <label for="report_text" class="block text-gray-700 text-sm font-bold mb-2">Radiology Report / Findings:</label>
            <textarea name="report_text" id="report_text" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>

        <div class="mb-6">
            <label for="image_file" class="block text-gray-700 text-sm font-bold mb-2">Upload Image/Scan (Optional):</label>
            <input type="file" name="image_file" id="image_file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-gray-500 text-xs mt-1">Supported formats: JPG, PNG. Max size: 10MB.</p>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                Submit Result
            </button>
        </div>
    </form>
</div>
@endsection
