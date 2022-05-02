<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'fees.*' => 'required|numeric|min:0',
            'fee_types.*' => [new Enum(FeeTypeEnum::class)],
            'fees.' . FeeTypeEnum::NightHotel->value => 'required|numeric|min:0|max:' . Carbon::now()->daysInMonth
        ];
        
        if (isset($this->label)) {
            $rulesArray = array_merge($rulesArray, [
                'label' => 'required|string',
                'created_at' => 'required|date_format:Y-m-d|before:tomorrow',
                'amount' => 'required|numeric|min:1|max:50',
                'proof' => 'sometimes|file|mimes:pdf,png,jpg|max:2048'
            ]);
        }

        return $rulesArray;
    }

    public function messages()
    {
        return [
            'fees.*.required' => 'Merci de renseigner tous les frais forfaitisés (laissez 0 si aucun).',
            'fees.' . FeeTypeEnum::NightHotel->value . '.min' => 'Le nombre de jours ne peut pas être négatif.',
            'fees.' . FeeTypeEnum::NightHotel->value . '.max' => 'Le nombre de jours ne peut pas être supérieur au nombre de jour du mois actuel.',
            'fee_types.*.Illuminate\Validation\Rules\Enum' => 'Les frais ne peuvent porter que sur `étape`, `kilomètres`, `nuit hotel` ou et `repas`', 
            'label.required' => 'Le libellé des frais hors forfaits est requis.',
            'created_at.required' => 'La date des frais hors forfaits est requis.',
            'created_at.before' => 'La date selectionnée ne doit pas exceder le jour même.',
            'proof.mimes' => 'Les types de fichiers autorisées sont: pdf, png et jpg.',
            'proof.max' => 'Le fichier ne doit pas dépasser 2048 ko.'
        ];
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

        if (isset($this->label)) {
            $this->merge([
                'amount' => str_replace(',', '.', request('amount'))
            ]);
        }
    }
}
