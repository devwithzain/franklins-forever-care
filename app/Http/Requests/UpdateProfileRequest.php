<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'email' => 'email,' . $this->user()->id,
        ];
    }
}
