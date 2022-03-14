<?php

namespace App\Http\Requests;

use App\Enums\Fee\FeeTypeEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rulesArray = [
            'fees' => 'array',
            'fees.*' => 'required|integer',
            'fee_types.*' => [new Enum(FeeTypeEnum::class)]
        ];

        if (isset($this->label)) {
            array_merge($rulesArray, [
                'label' => 'required|string',
                'created_at' => 'required|date_format:yyyy-mm-dd',
                'amount' => 'required|integer',
            ]);
        }

        return $rulesArray;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'fee_types' => array_keys($this->fees)
        ]);
    }
}
