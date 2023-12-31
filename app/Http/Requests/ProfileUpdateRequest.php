<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'lastName' => ['string', 'max:255'],
            'dob' => ['date', 'before:' . now()->subYears(13)->format('Y-m-d')],
            'profileImage' => [
                'file' => 'min:10', 'max:4096', 'mimes:jpg,jpeg,png',
            ],
            'gender' => ['string', 'max:20'],
            'address' => 'string|max:500',
            'contactNo' => 'integer|min:10|max:10'
        ];
    }
}
