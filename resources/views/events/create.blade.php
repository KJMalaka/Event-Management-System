<x-app-layout>
    @section('title', 'Create Event - ' . config('app.name'))

    <x-slot name="header">Create New Event</x-slot>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @include('events._form')

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" name="status" value="draft"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 rounded-lg transition">
                    Save as Draft
                </button>
                <button type="submit" name="status" value="published"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                    Publish Event
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
