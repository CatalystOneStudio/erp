<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\Loan;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanRequestResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-up';

    protected static ?string $navigationGroup = 'Loan Management';

    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('loan_status', 'requested'))
            ->columns([
                Tables\Columns\TextColumn::make('borrower.name')
                    ->label('Borrower')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'requested' => 'warning',
                        'processing' => 'info',
                        'approved' => 'success',
                        'disbursed' => 'success',
                        'completed' => 'success',
                        'defaulted' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('principal_amount')
                    ->money('usd')
                    ->label('Principal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_release_date')
                    ->date()
                    ->label('Release Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_duration')
                    ->label('Duration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_period')
                    ->label('Period')
                    ->sortable(),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->suffix('%')
                    ->label('Interest Rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('repayment_cycle')
                    ->label('Repayment Cycle')
                    ->sortable(),
                Tables\Columns\TextColumn::make('collateral_name')
                    ->label('Collateral')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('borrower_id')
                    ->relationship('borrower', 'name')
                    ->label('Borrower'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanRequestResource\Pages\ListLoanRequests::route('/'),
            'view' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanRequestResource\Pages\ViewLoanRequest::route('/{record}'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Loan Request';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Loan Requests';
    }
}
