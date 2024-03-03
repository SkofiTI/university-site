<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterestItemsResource\Pages;
use App\Filament\Resources\InterestItemsResource\RelationManagers;
use App\Models\Interest;
use App\Models\InterestItems;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InterestItemsResource extends Resource
{
    protected static ?string $model = InterestItems::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('interest_id')
                ->relationship('Interest', 'name')
                ->options(function ($get) {
                    return Interest::query()
                        ->pluck('name', 'id')
                        ->toArray();
                }),
                Forms\Components\TextInput::make('item')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('interest_id'),
                Tables\Columns\TextColumn::make('item'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInterestItems::route('/'),
            'create' => Pages\CreateInterestItems::route('/create'),
            'edit' => Pages\EditInterestItems::route('/{record}/edit'),
        ];
    }    
}
