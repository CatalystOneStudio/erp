<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\Bank;
use Filament\Forms;
use Webkul\Support\Models\Country;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BankResource extends Resource
{
    protected static ?string $model = Bank::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?string $navigationGroup = 'Accounting';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bank Details')
                    ->description('Enter the details of the bank.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('swift_code')
                            ->maxLength(11)
                            ->nullable(),
                        Forms\Components\TextInput::make('routing_number')
                            ->maxLength(20)
                            ->nullable(),
                        Forms\Components\Select::make('country')
                            ->options(Country::all()->pluck('name', 'name'))
                            ->searchable()
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('swift_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('routing_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource\Pages\ListBanks::route('/'),
            'create' => \Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource\Pages\CreateBank::route('/create'),
            'edit' => \Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource\Pages\EditBank::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'swift_code',
            'routing_number',
            'country',
        ];
    }
}
