<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('workplace')
                    ->default(null),
                TextInput::make('position')
                    ->default(null),
                TextInput::make('academic_degree')
                    ->default(null),
                Toggle::make('is_admin')
                    ->required(),
                Toggle::make('is_verified_manually')
                    ->required(),
                DateTimePicker::make('membership_paid_until'),
                Select::make('membership_type')
                    ->options(['individual' => 'Individual', 'organization' => 'Organization'])
                    ->default('individual')
                    ->required(),
            ]);
    }
}
