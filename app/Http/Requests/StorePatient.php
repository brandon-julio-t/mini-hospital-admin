<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePatient extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isStaff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sex' => 'required|string|in:Male,Female',
            'phone_number' => 'required|digits:12',
            'date_of_birth' => 'required|date|before:today',
            'address' => 'required|string|max:255',
            'doctor_id' => 'required|string|size:5|exists:doctors,id',
        ];
    }
}
