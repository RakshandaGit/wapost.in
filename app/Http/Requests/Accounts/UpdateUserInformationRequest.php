<?php

namespace App\Http\Requests\Accounts;

use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
                'phone'      => ['required', new Phone($this->phone), 'numeric', 'digits:12', 'unique:users,phone,'. Auth::id()],
                // 'phone'   => ['required', new Phone($this->phone),'numeric', 'digits:12',],
                'website' => ['nullable', 'url'],
                'address' => ['required', 'string'],
                'city'    => ['required', 'string'],
                'country' => ['required', 'string'],
        ];
    }
}
