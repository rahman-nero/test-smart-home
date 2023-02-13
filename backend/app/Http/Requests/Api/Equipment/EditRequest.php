<?php

namespace App\Http\Requests\Api\Equipment;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $id = $this->route()->parameters['id'];

        return [
            'type_id' => 'required|integer|exists:equipment_type,id',
            'serial_number' => [
                'required',
                'string',
                Rule::unique('equipments', 'serial_number')
                    ->ignore($id)
            ],
            'comment' => 'nullable|string',
        ];
    }

}
