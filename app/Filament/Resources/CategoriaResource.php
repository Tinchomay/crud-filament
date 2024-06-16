<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\CategoriaResource\Pages;
use App\Filament\Resources\CategoriaResource\RelationManagers;
use App\Models\Categoria;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ImageColumn;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //Aqui podemos mostrar el input, tiene que tener el nombre de la columna y podemos crear reglas para ese input
                //Textinput para texto
                TextInput::make('categoria')->required()->maxLength(100)
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //Columnas tienen que tener el mismo nombre de la columna,podemos agregar atributos
                TextColumn::make('categoria')->searchable(),
                //toggleable hace que se cree un menu para agregar estos campos, date time especifica que es una fecha, sortable que se pueda ordenar
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault:true)
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
            'index' => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit' => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }
}
