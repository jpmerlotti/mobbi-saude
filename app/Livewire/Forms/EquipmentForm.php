<?php

namespace App\Livewire\Forms;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Livewire\Component;

class EquipmentForm
{
    public static function make(Schema $schema): Schema
    {
        return static::configure($schema, new Equipment());
    }

    public static function configure(Schema $schema, ?Equipment $equipment): Schema
    {
        $isEdit = $equipment?->exists();

        return $schema->components([
            FileUpload::make('images')
                ->label('Fotos do Equipamento')
                ->disk('s3')
                ->directory($isEdit ? 'equipments/' . $equipment->id : null)
                ->multiple()
                ->reorderable()
                ->appendFiles()
                ->image()
                ->imageEditor()
                ->columnSpanFull(),
            TextInput::make('name')
                ->label('Nome do Equipamento')
                ->required()->maxLength(255),
            Select::make('equipment_type_id')
                ->label('Tipo de Equipamento')
                ->options(self::types()->pluck('name', 'id'))
                ->required(),
            RichEditor::make('description')
                ->label('Descrição')
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                    ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                    ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                    ['undo', 'redo'],
                ])
                ->columnSpanFull(),
            Toggle::make('is_available')
                ->label('Disponível'),
        ])
        ->model($equipment)
        ->columns([
            'xs' => 1,
            'md' => 2
        ]);
    }

    public static function types()
    {
        return EquipmentType::all();
    }
}
