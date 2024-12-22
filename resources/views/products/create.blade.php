@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
    <div class="max-w-3xl mx-auto"  class="bg-gray-900">
        <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="#">
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold text-gray-900">Form Title</h2>
                    <p class="mt-1 text-sm text-gray-600">Provide the necessary details below.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <!-- Input field example -->
                        <div class="sm:col-span-4">
                            <label for="input-name" class="block text-sm font-medium text-gray-900">Input Label</label>
                            <div class="mt-2">
                                <input type="text" name="input-name" id="input-name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-indigo-600 sm:text-sm" placeholder="Enter text here">
                            </div>
                        </div>

                        <!-- Textarea field example -->
                        <div class="col-span-full">
                            <label for="textarea-name" class="block text-sm font-medium text-gray-900">Textarea Label</label>
                            <div class="mt-2">
                                <textarea name="textarea-name" id="textarea-name" rows="3" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-indigo-600 sm:text-sm" placeholder="Enter details here"></textarea>
                            </div>
                        </div>

                        <!-- Select dropdown example -->
                        <div class="sm:col-span-3">
                            <label for="select-name" class="block text-sm font-medium text-gray-900">Select Label</label>
                            <div class="mt-2 grid grid-cols-1">
                                <select id="select-name" name="select-name" class="block w-full rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-indigo-600 sm:text-sm">
                                    <option value="option1">Option 1</option>
                                    <option value="option2">Option 2</option>
                                    <option value="option3">Option 3</option>
                                </select>
                            </div>
                        </div>

                        <!-- File upload example -->
                        <div class="col-span-full">
                            <label for="file-upload" class="block text-sm font-medium text-gray-900">File Upload</label>
                            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                <div class="text-center">
                                    <label for="file-upload" class="cursor-pointer text-indigo-600 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                    </label>
                                    <p class="mt-1 text-xs text-gray-600">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Submit button -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="reset" class="text-sm font-semibold text-gray-900">Cancel</button>
                <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
@endsection
