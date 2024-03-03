<?php

namespace App\Filament\Resources\InterestItemsResource\Pages;

use App\Filament\Resources\InterestItemsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInterestItems extends ListRecords
{
    protected static string $resource = InterestItemsResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
