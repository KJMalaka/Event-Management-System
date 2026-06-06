<x-app-layout>
    @section('title', 'Edit Event - ' . config('app.name'))

    <x-slot name="header">Edit: {{ $event->title }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('events.update', $event->slug) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')
            @include('events._form')

            <div class="flex items-center justify-between pt-2">
                <form method="POST" action="{{ route('events.destroy', $event->slug) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline"
                            onclick="return confirm('Permanently delete this event?')">
                        Delete Event
                    </button>
                </form>

                <div class="flex gap-3">
                    <a href="{{ route('events.show', $event->slug) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
