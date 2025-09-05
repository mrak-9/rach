<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                TextEntry::make('phone'),
                TextEntry::make('city'),
                TextEntry::make('workplace'),
                TextEntry::make('position'),
                TextEntry::make('academic_degree'),
                IconEntry::make('is_admin')
                    ->boolean(),
                IconEntry::make('is_verified_manually')
                    ->boolean(),
                TextEntry::make('membership_paid_until')
                    ->dateTime(),
                TextEntry::make('membership_type'),
            ]);
    }
}
