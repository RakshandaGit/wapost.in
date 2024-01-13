<?php

namespace App\Http\Requests\Contacts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateContactGroupMessage extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update_contact_group');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
                //'message_form' => 'required',
                'message'      => 'required',
        ];
    }
    public function withValidator($validator)
    { 
        $urls = explode('/',FormRequest::url());
        return redirect()->route('customer.contacts.show', $urls[4])->withInput(['tab' => 'message'])->with([
            'status'  => 'error',
            'message' => __('Message is Empty'),
        ]);
    }
    
}
