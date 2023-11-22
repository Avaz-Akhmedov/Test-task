<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'categories' => ['array','exists:categories,id'],
            'priceFrom' => ['numeric','min:1'],
            'priceTo' => ['numeric','min:1'],
        ];
    }
}
