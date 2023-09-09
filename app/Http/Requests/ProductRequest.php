<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('products', 'name')->ignore($this->product)],
            'price' => ['required'],
            'status' => ['nullable'],
            'picture' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
        ];
    }

    public function getData(): array
    {
        dd($this->all());
        return array_merge($this->validated(), [
            'picture' => $this->hasFile('picture') ? $this->file('picture')->store('products') : null,
        ]);
    }
}
