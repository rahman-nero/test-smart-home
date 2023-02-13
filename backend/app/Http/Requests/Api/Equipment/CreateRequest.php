<?php

namespace App\Http\Requests\Api\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'equipments' => 'required|array',
            'equipments.*.equipment_type_id' => 'required|integer|exists:equipment_type,id',
            'equipments.*.serial_number' => 'required|string|unique:equipments,serial_number',
            'equipments.*.comment' => 'nullable|string',
        ];
    }

}
