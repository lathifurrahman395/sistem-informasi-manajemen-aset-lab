<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\ExportsCsv;
use App\Filament\Resources\LocationResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LocationResource extends Resource
{
    use ExportsCsv;

    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationLabel = 'Ruangan Lab';

    protected static ?string $modelLabel = 'Ruangan Lab';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Ruangan Laboratorium')
                    ->description('Masukkan data detail mengenai ruangan laboratorium komputer.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lab')
                            ->required()
                            ->label('Nama Laboratorium')
                            ->placeholder('Contoh: Lab 1'),

                        Forms\Components\TextInput::make('kepala_lab')
                            ->label('Dosen Kepala Lab')
                            ->placeholder('Contoh: T. Jufri, S.Kom., M.T.'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lab')
                    ->label('Nama Laboratorium')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kepala_lab')
                    ->label('Kepala Lab')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                static::csvExportAction(
                    filename: 'ruangan-lab.csv',
                    headers: ['Nama Laboratorium', 'Kepala Lab'],
                    query: fn() => static::getModel()::query()->orderBy('nama_lab')->get(),
                    rowMapper: fn($r) => [
                        $r->nama_lab,
                        $r->kepala_lab,
                    ],
                ),
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
