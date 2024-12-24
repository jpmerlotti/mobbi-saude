<?php

namespace App\Enums;

enum EquipmentStatusEnum: string
{
    case New = 'new';
    case Used = 'used';
    case Damage = 'damage';

    public static function toArray(): array
    {
        $data = [];

        foreach (self::cases() as $status) {
            $data[$status->value] = $status->label();
        }

        return $data;
    }

    public function label(): string
    {
        return match ($this) {
            self::New => 'Novo',
            self::Used => 'Usado',
            self::Damage => 'Danificado'
        };
    }
}
