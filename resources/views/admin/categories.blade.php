<x-app-layout>
    @section('title', 'Categories - Admin')

    <x-slot name="header">Event Categories</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Category</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Events</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Color</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($categories as $cat)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-200">{{ $cat->name }}</div>
                                    @if($cat->description)
                                        <div class="text-xs text-gray-400">{{ $cat->description }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $cat->events_count }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-5 h-5 rounded-full border border-gray-200" style="background-color: {{ $cat->color }}"></div>
                                        <span class="text-xs text-gray-400 font-mono">{{ $cat->color }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 h-fit">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Add Category</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="cat_name" value="Name" />
                    <x-text-input id="cat_name" name="name" type="text" class="mt-1 block w-full"
                                  value="{{ old('name') }}" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="cat_description" value="Description (optional)" />
                    <x-text-input id="cat_description" name="description" type="text" class="mt-1 block w-full"
                                  value="{{ old('description') }}" />
                </div>
                <div>
                    <x-input-label for="cat_color" value="Color" />
                    <input id="cat_color" name="color" type="color" value="{{ old('color', '#3B82F6') }}"
                           class="mt-1 h-10 w-full rounded-lg border-gray-300 dark:border-gray-600 cursor-pointer">
                    <x-input-error :messages="$errors->get('color')" class="mt-1" />
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-lg transition">
                    Add Category
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
