<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'description' => ['required', 'string'],
            'categories' => ['required', 'unique:events', 'string'],
            'place' => ['required', 'string'],
            'image_url' => ['required', 'string', 'mimes:png,jpg,jpeg'],
            'status' => [],
            'start' => ['required','date'],
            'end' => ['required','date'],
        ];
    }

    public function messsage(): array {
        return [
            'categorie.unique' => 'Cette categorie existe déjà.',
            'image_url.mimes' => 'Les formats d\'images autorisés sont le png, jpg et jpeg'
        ];
    }
}
