<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequestK extends FormRequest
{
    public function authorize(): bool
    {
        $event = $this->route('event');
        return $this->user()->isAdmin()
            || ($this->user()->isOrganizer() && $event->organizer_id === $this->user()->id);
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255', 'min:5'],
            'description'       => ['required', 'string', 'min:20'],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'location'          => ['required', 'string', 'max:255'],
            'venue'             => ['nullable', 'string', 'max:255'],
            'start_date'        => ['required', 'date'],
            'end_date'          => ['required', 'date', 'after:start_date'],
            'capacity'          => ['required', 'integer', 'min:1'],
            'price'             => ['required', 'numeric', 'min:0'],
            'status'            => ['required', 'in:draft,published,cancelled'],
            'banner_image'      => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'],
            'requires_approval' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.min'       => 'The event title must be at least 5 characters.',
            'description.min' => 'Please provide a meaningful event description.',
            'end_date.after'  => 'The end date must be after the start date.',
        ];
    }
}
