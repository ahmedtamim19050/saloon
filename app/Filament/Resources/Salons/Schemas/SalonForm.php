<?php

namespace App\Filament\Resources\Salons\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SalonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Salon Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->image()
                            ->directory('salons')
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Location')
                    ->schema([
                        TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('city')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('state')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),
                
                Section::make('Working Hours')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TimePicker::make('opening_time')
                                    ->required(),
                                TimePicker::make('closing_time')
                                    ->required(),
                            ]),
                        CheckboxList::make('working_days')
                            ->options([
                                'Monday' => 'Monday',
                                'Tuesday' => 'Tuesday',
                                'Wednesday' => 'Wednesday',
                                'Thursday' => 'Thursday',
                                'Friday' => 'Friday',
                                'Saturday' => 'Saturday',
                                'Sunday' => 'Sunday',
                            ])
                            ->columns(4)
                            ->required(),
                    ]),
            ]);
    }
}
