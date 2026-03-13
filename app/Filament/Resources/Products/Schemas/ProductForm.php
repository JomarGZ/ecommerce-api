<?php

declare(strict_types=1);

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

final class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Basic Information')
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('brand_id')
                                            ->label('Brand')
                                            ->options(Brand::query()->pluck('name', 'id'))
                                            ->searchable()
                                            ->required()
                                            ->createOptionForm([
                                                TextInput::make('name')->required()

                                            ])
                                            ->createOptionUsing(
                                                fn (array $data) => Brand::create($data)->id
                                            ),
                                        Textarea::make('description')
                                            ->columnSpanFull()
                                            ->rows(4)
                                    ])
                            ]),
                        Tab::make('Variant')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Repeater::make('variants')
                                    ->relationship()
                                    ->schema([
                                        TextInput::make('sku')
                                            ->label('SKU')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(100)
                                            ->columnSpan(2),

                                        TextInput::make('price')
                                            ->numeric()
                                            ->prefix('$')
                                            ->required()
                                            ->minValue(0),

                                        TextInput::make('stock')
                                            ->numeric()
                                            ->default(0)
                                            ->minValue(0),

                                        Repeater::make('attributes')
                                            ->relationship()
                                            ->schema([
                                                TextInput::make('attribute_name')
                                                    ->label('Attribute')
                                                    ->required()
                                                    ->placeholder('e.g. color, storage'),
    
                                                TextInput::make('attribute_value')
                                                    ->label('Value')
                                                    ->required()
                                                    ->placeholder('e.g. black, 128GB'),
                                            ])
                                            ->columns(2)
                                            ->columnSpanFull()
                                            ->addActionLabel('Add attribute')
                                            ->defaultItems(0)
                                            ->collapsible()
                                    ])
                                    ->columns()
                                    ->addActionLabel('Add Variant')
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['sku'] ?? null)
                            ])       
                    ])
            ]);
    }
}
