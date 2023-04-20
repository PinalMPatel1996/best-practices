<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Post::class);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'body' => ['required_without:file', 'string', 'max:255'],
            'visibility' => ['required', Rule::in(Post::visibilities())],
            'is_published' => ['required', 'boolean'],
            'file' => ['required_without:body', 'file' , 'mimes:jpg,jpeg,png', 'max:14000', 'min:10'],
        ];
    }
}
