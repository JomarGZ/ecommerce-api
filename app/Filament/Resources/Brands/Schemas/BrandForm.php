<?php

declare(strict_types=1);

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->minLength(3)
                    ->maxLength(100)
                    ->trim(),
                TextInput::make('slug')
                    ->readOnly()
                    ->helperText('This slug is automatically generated from the name.'),
            ]);
    }
}
