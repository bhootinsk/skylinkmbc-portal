<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $extensions = implode(',', config('portal.allowed_extensions'));

        return [
            'file' => [
                'required',
                'file',
                'max:'.config('portal.max_upload_size_kb'),
                'mimes:'.$extensions,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.max' => 'Files may not exceed '.(config('portal.max_upload_size_kb') / 1024).' MB.',
            'file.mimes' => 'Allowed file types: '.implode(', ', config('portal.allowed_extensions')).'.',
        ];
    }
}
