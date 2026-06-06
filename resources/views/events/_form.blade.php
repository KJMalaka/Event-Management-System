<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-5">
    {{-- Title --}}
    <div>
        <x-input-label for="title" value="Event Title" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      value="{{ old('title', $event->title ?? '') }}" required />
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
    </div>

    {{-- Description --}}
    <div>
        <x-input-label for="description" value="Description" />
        <textarea id="description" name="description" rows="5"
                  class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500"
                  required>{{ old('description', $event->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-1" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Category --}}
        <div>
            <x-input-label for="category_id" value="Category" />
            <select id="category_id" name="category_id"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">— No Category —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $event->category_id ?? '') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
        </div>

        {{-- Price --}}
        <div>
            <x-input-label for="price" value="Price (R)" />
            <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="mt-1 block w-full"
                          value="{{ old('price', $event->price ?? '0') }}" required />
            <x-input-error :messages="$errors->get('price')" class="mt-1" />
        </div>
    </div>

    {{-- Location & Venue --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="location" value="Location (City, Country)" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full"
                          value="{{ old('location', $event->location ?? '') }}" required />
            <x-input-error :messages="$errors->get('location')" class="mt-1" />
        </div>
        <div>
            <x-input-label for="venue" value="Venue Name (optional)" />
            <x-text-input id="venue" name="venue" type="text" class="mt-1 block w-full"
                          value="{{ old('venue', $event->venue ?? '') }}" />
            <x-input-error :messages="$errors->get('venue')" class="mt-1" />
        </div>
    </div>

    {{-- Dates --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="start_date" value="Start Date & Time" />
            <x-text-input id="start_date" name="start_date" type="datetime-local" class="mt-1 block w-full"
                          value="{{ old('start_date', isset($event) ? $event->start_date->format('Y-m-d\TH:i') : '') }}" required />
            <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
        </div>
        <div>
            <x-input-label for="end_date" value="End Date & Time" />
            <x-text-input id="end_date" name="end_date" type="datetime-local" class="mt-1 block w-full"
                          value="{{ old('end_date', isset($event) ? $event->end_date->format('Y-m-d\TH:i') : '') }}" required />
            <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
        </div>
    </div>

    {{-- Capacity & Status --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="capacity" value="Capacity (max attendees)" />
            <x-text-input id="capacity" name="capacity" type="number" min="1" class="mt-1 block w-full"
                          value="{{ old('capacity', $event->capacity ?? 100) }}" required />
            <x-input-error :messages="$errors->get('capacity')" class="mt-1" />
        </div>
        <div>
            <x-input-label for="status" value="Status" />
            <select id="status" name="status"
                    class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="draft" @selected(old('status', $event->status ?? 'draft') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $event->status ?? '') === 'published')>Published</option>
                @if(isset($event) && $event->exists)
                    <option value="cancelled" @selected($event->status === 'cancelled')>Cancelled</option>
                @endif
            </select>
        </div>
    </div>

    {{-- Banner Image --}}
    <div>
        <x-input-label for="banner_image" value="Banner Image (optional, max 2MB)" />
        @if(isset($event) && $event->banner_image)
            <img src="{{ asset('storage/' . $event->banner_image) }}" class="mt-2 h-24 rounded-lg object-cover" alt="Current banner">
            <p class="text-xs text-gray-500 mt-1">Upload a new image to replace the current one.</p>
        @endif
        <input id="banner_image" name="banner_image" type="file" accept="image/*"
               class="mt-1 block w-full text-sm text-gray-600 dark:text-gray-400
                      file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                      file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200">
        <x-input-error :messages="$errors->get('banner_image')" class="mt-1" />
    </div>

    {{-- Requires Approval --}}
    <div class="flex items-center gap-3">
        <input type="checkbox" id="requires_approval" name="requires_approval" value="1"
               @checked(old('requires_approval', $event->requires_approval ?? false))
               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
        <label for="requires_approval" class="text-sm text-gray-700 dark:text-gray-300">
            Require organizer approval for registrations
        </label>
    </div>
</div>
