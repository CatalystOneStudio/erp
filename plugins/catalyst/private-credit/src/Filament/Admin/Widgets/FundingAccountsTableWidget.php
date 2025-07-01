<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Widgets;

use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Catalyst\PrivateCredit\Models\FundingAccount;
use Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource;

class FundingAccountsTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Funding Accounts';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(FundingAccount::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Account')
                    ->placeholder('No parent account')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank.name')
                    ->label('Bank')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bank_account_number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('bank_account_holder_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('status')
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
                    ->url(FundingAccountResource::getUrl('create')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (FundingAccount $record): string => FundingAccountResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
