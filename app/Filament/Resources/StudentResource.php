<?php

namespace App\Filament\Resources;

use App\Exports\StudentsExport;
use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = "Academics Management";

    public static function getNavigationBadge(): ?string
    {
        return "60";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->autofocus(),
                Forms\Components\TextInput::make('email')->email()->unique(),
                Forms\Components\Select::make('class_id')->relationship('class', 'name')->live(),
                Forms\Components\Select::make('section_id')->relationship('section', 'name')->options(function (Forms\Get $get) {
                    $class_id = $get('class_id');
                    if ($class_id) {
                        return Section::where('class_id', $class_id)->get()->pluck('name', 'id');
                    }
                })

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('class.name')->searchable()->sortable()->badge(),
                Tables\Columns\TextColumn::make('section.name')->searchable()->sortable()->badge()
            ])
            ->filters([
                Tables\Filters\Filter::make("class-section-filter")
                    ->form([
                        Forms\Components\Select::make('class_id')
                            ->relationship('class', 'name')->label('Filter by class'),
                        Forms\Components\Select::make('section_id')
                            ->options(function (Forms\Get $get) {
                                $class_id = $get('class_id');
                                if ($class_id) {
                                    return Section::where('class_id', $class_id)->pluck('name', 'id')->toArray();
                                }
                            })
                    ])->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['class_id'], function ($query) use ($data) {
                                return $query->where('class_id', $data['class_id']);
                            })
                            ->when($data['section_id'], function (Builder $query) use ($data){
                                return $query->where('section_id',$data['section_id']);
                            });
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Records')
                        ->icon('heroicon-o-table-cells')
                        ->action(function (Collection $records) {
                            return (new StudentsExport($records))->download('students.xlsx');
                        }) // Illuminate/Database/Eloquent
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
