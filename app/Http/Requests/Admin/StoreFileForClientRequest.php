<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileForClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $extensions = implode(',', config('portal.allowed_extensions'));

        return [
            'client_id' => ['required', 'exists:users,id'],
            'file' => [
                'required',
                'file',
                'max:'.config('portal.max_upload_size_kb'),
                'mimes:'.$extensions,
            ],
        ];
    }
}
