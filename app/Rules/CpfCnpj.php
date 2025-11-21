<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Stringable;

class CpfCnpj implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $document = preg_replace('/[^0-9]/', '', (string) $value);

        if (strlen($document) === 11) {
            if (!$this->isCpfValid($document)) {
                $fail('O :attribute não é um CPF válido.');
            }
        } elseif (strlen($document) === 14) {
            if (!$this->isCnpjValid($document)) {
                $fail('O :attribute não é um CNPJ válido.');
            }
        } else {
            $fail('O :attribute deve ser um CPF ou CNPJ.');
        }
    }

    private function isCpfValid(string $cpf): bool
    {
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }

        return true;
    }

    private function isCnpjValid(string $cnpj): bool
    {
        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) return false;

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
