<?php

namespace App\Filament\Resources\Conferences\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ConferenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('registration_opens_at')
                    ->date(),
                TextEntry::make('starts_at')
                    ->date(),
                TextEntry::make('ends_at')
                    ->date(),
                TextEntry::make('location'),
                TextEntry::make('conference_type'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
