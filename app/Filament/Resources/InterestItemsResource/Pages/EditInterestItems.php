<?php

namespace App\Filament\Resources\InterestItemsResource\Pages;

use App\Filament\Resources\InterestItemsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInterestItems extends EditRecord
{
    protected static string $resource = InterestItemsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
