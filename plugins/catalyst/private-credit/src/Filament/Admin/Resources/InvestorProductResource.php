<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorProductResource\Pages;
use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorProductResource\RelationManagers;
use Catalyst\PrivateCredit\Models\InvestorProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestorProductResource extends Resource
{
    protected static ?string $model = InvestorProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Investor Management';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Add an Investor Product')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->columnSpan(2),
                        Forms\Components\Select::make('interest_type')
                            ->options([
                                'flat' => 'Flat Interest',
                                'compounded' => 'Compounded Interest',
                            ])
                            ->default('flat')
                            ->live()
                            ->helperText(fn (Forms\Get $get): string => [
                                'flat' => 'Flat interest is calculated on the original principal each time, without compounding on previous interest. For example, if the balance is 1,000, the interest will always be calculated on 1,000, regardless of previous interest amounts.',
                                'compounded' => 'Interest is compounded onto the balance, meaning each new calculation includes previously accrued interest. For example, if your initial balance is 1,000 and the total accumulated interest is 100, the next interest calculation will be based on 1,100.'
                            ][$get('interest_type')])
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('interest_rate')
                            ->numeric()
                            ->suffix('%')
                            ->required(),
                        Forms\Components\Select::make('interest_cycle')
                            ->options([
                                'monthly' => 'Monthly',
                                'quarterly' => 'Quarterly',
                                'semi-annually' => 'Semi-Annually',
                                'yearly' => 'Yearly',
                            ])
                            ->default('monthly')
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
                Tables\Columns\TextColumn::make('interest_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->numeric()
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('interest_cycle')
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
            'index' => Pages\ListInvestorProducts::route('/'),
            'create' => Pages\CreateInvestorProduct::route('/create'),
            'edit' => Pages\EditInvestorProduct::route('/{record}/edit'),
        ];
    }
}
