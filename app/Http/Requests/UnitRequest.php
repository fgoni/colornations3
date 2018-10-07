<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

/**
 * @property mixed berserkers
 * @property mixed paladins
 * @property mixed merchants
 * @property mixed injured
 * @property mixed archers
 * @property mixed saboteurs
 * @property mixed spies
 */
class UnitRequest extends Request
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
            'berserkers' => 'numeric|min:1',
            'paladins'   => 'numeric|min:1',
            'archers'    => 'numeric|min:1',
            'saboteurs'  => 'numeric|min:1',
            'merchants'  => 'numeric|min:1',
            'spies'      => 'numeric|min:1',
            'injured'    => 'numeric|min:1',
        ];
    }
}
