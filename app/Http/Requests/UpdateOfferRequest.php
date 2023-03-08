<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (($this->user()->access_level > 1) && ($this->user()->advertiser || $this->user()->admin));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'subjects' => ['nullable', 'string', 'max:254'],
            'advertiser_id' => ['required', 'numeric'],
            'url' => ['required', 'string', 'max:2048'],
            'price' => ['numeric'],
            'active' => ['required', 'boolean']
        ];
    }
}
