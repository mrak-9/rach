<?php

namespace App\Filament\Resources\Conferences\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ConferenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                DatePicker::make('registration_opens_at')
                    ->required(),
                DatePicker::make('starts_at')
                    ->required(),
                DatePicker::make('ends_at'),
                TextInput::make('location')
                    ->required(),
                TextInput::make('conference_type')
                    ->required(),
                Textarea::make('announcement')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('important_dates')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('events')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('post_release')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('materials')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
