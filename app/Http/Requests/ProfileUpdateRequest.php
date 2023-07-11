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
            'lastName' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date', 'before:' . now()->subYears(13)->format('Y-m-d')],
            'profileImage' => ['required', File::types(['jpg', 'png'])
                ->min(1)
                ->max(12 * 1024),],
            'gender' => ['required','string','max:20'],
            'address' => 'required|string|max:500',
            'contactNo' => 'required|string|min:10|max:10'
        ];
    }
}
