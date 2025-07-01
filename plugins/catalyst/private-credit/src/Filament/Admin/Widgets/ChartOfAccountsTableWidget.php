<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Catalyst\PrivateCredit\Filament\Admin\Resources\ChartOfAccountResource;

class ChartOfAccountsTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Chart of Accounts';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(ChartOfAccount::query())
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Account')
                    ->placeholder('No parent account')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('account_type')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => str($state)->title()),
                Tables\Columns\TextColumn::make('cashflow_type')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => str($state)->replace('_', ' ')->title()),
                Tables\Columns\IconColumn::make('is_enabled')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->url(ChartOfAccountResource::getUrl('create')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (ChartOfAccount $record): string => ChartOfAccountResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
