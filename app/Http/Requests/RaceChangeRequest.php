<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class RaceChangeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'race' => 'numeric|between:1,4',
        ];
    }
}
