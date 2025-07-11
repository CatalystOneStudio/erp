<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\Investor;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvestorResource extends Resource
{
    protected static ?string $model = Investor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Investor Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->image()
                            ->avatar()
                            ->directory('investor-avatars')
                            ->nullable()
                            ->alignCenter()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                            ])
                            ->default('male')
                            ->required(),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required(),
                        Forms\Components\Select::make('identification_type')
                            ->options([
                                'id' => 'ID',
                                'passport' => 'Passport',
                                'drivers_license' => 'Drivers License'
                            ])
                            ->default('id')
                            ->required(),
                        Forms\Components\TextInput::make('identification_value')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tax_identification_number')
                            ->maxLength(255),
                    ]),
                Forms\Components\Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('primary_phone_number')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('secondary_phone_number')
                            ->tel()
                            ->nullable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('state_province')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zipcode')
                            ->maxLength(255),
                    ]),
                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('files')
                            ->multiple()
                            ->directory('investor-files')
                            ->image()
                            ->imageEditor()
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('primary_phone_number')
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => InvestorResource\Pages\ListInvestors::route('/'),
            'create' => InvestorResource\Pages\CreateInvestor::route('/create'),
            'view' => InvestorResource\Pages\ViewInvestor::route('/{record}'),
            'edit' => InvestorResource\Pages\EditInvestor::route('/{record}/edit'),
        ];
    }
}
