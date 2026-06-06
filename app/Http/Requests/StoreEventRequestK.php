<?php

namespace App\Http\Requests;

use App\Rules\FutureDateRuleK;
use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequestK extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->canManageEvents();
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255', 'min:5'],
            'description'       => ['required', 'string', 'min:20'],
            'category_id'       => ['nullable', 'exists:categories,id'],
            'location'          => ['required', 'string', 'max:255'],
            'venue'             => ['nullable', 'string', 'max:255'],
            'start_date'        => ['required', 'date', new FutureDateRuleK()],
            'end_date'          => ['required', 'date', 'after:start_date'],
            'capacity'          => ['required', 'integer', 'min:1', 'max:100000'],
            'price'             => ['required', 'numeric', 'min:0'],
            'status'            => ['required', 'in:draft,published'],
            'banner_image'      => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,webp'],
            'requires_approval' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.min'          => 'The event title must be at least 5 characters.',
            'description.min'    => 'Please provide a meaningful event description (at least 20 characters).',
            'start_date.date'    => 'Please provide a valid start date.',
            'end_date.after'     => 'The end date must be after the start date.',
            'capacity.min'       => 'The event must have at least 1 attendee slot.',
            'price.min'          => 'The price cannot be negative.',
            'banner_image.max'   => 'The banner image may not exceed 2 MB.',
            'banner_image.mimes' => 'The banner image must be a JPEG, PNG, or WebP file.',
        ];
    }
}
