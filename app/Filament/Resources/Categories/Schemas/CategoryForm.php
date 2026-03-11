<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->trim()
                    ->minLength(3)
                    ->maxLength(100),
                TextInput::make('slug')
                    ->readOnly()
                    ->helperText('This slug is automatically generated from the name.')
            ]);
    }
}
