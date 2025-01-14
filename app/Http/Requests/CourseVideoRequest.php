<?php

namespace App\Http\Requests;

use Alaouy\Youtube\Rules\ValidYoutubeVideo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            // 'link' => ['bail', 'required', new ValidYoutubeVideo],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul harus diisi.',
            'title.max' => 'Judul tidak boleh lebih dari 255 karakter.',
            'link.required' => 'Link harus diisi.',
        ];
    }
}
