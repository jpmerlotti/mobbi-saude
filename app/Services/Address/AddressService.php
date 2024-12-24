<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Services\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressService extends Service
{
    private function validate(array $data): void
    {
        $rules = [
            'city' => 'required|string',
            'street' => 'required|string',
            'district' => 'required|string',
            'state' => 'required|string',
            'number' => 'required|int',
            'complement' => 'nullable|string|max:255',
            'cep' => 'required|string',
        ];

        $messages = [
            'number.required' => 'O campo Número é obrigatório.',
            'number.int' => 'O campo Número deve conter apenas números inteiros.',
            'city.required' => 'O campo Cidade é obrigatório.',
            'street.required' => 'O campo Rua é obrigatório.',
            'district.required' => 'O campo Bairro é obrigatório.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'complement.max' => 'O campo Complemento pode ter no máximo 255 caracteres.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function save(array $data): bool
    {
        $this->validate($data);

        $user = auth()->user();

        try {
            if ($user->address != null) {
                $user->address()->update($data);
            } else {
                $user->address()->create($data);
            }
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
    }
}
