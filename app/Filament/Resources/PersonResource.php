<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\PersonResource\Pages;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'People';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')->email()->required(),
                        Forms\Components\TextInput::make('job_title')->maxLength(255),
                        Forms\Components\TextInput::make('location')->maxLength(255),
                        Forms\Components\Select::make('employee_type')
                            ->options(['employee' => 'Employee', 'contractor' => 'Contractor'])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make('Reporting')
                    ->schema([
                        Forms\Components\Select::make('manager_id')
                            ->label('Manager')
                            ->relationship('manager', 'name')
                            ->searchable(),
                        Forms\Components\DatePicker::make('join_date'),
                        Forms\Components\DateTimePicker::make('leave_date'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('job_title')->label('Role'),
                Tables\Columns\BadgeColumn::make('employee_type')->colors([
                    'primary' => 'employee',
                    'warning' => 'contractor',
                ]),
                Tables\Columns\BadgeColumn::make('status')->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ]),
                Tables\Columns\TextColumn::make('manager.name')->label('Manager'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeople::route('/'),
            'create' => Pages\CreatePerson::route('/create'),
            'edit' => Pages\EditPerson::route('/{record}/edit'),
        ];
    }
}
