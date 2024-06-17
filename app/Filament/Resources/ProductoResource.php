<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Producto;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Intervention\Image\Image;
use Filament\Resources\Resource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductoResource\RelationManagers;

class ProductoResource extends Resource
{
    protected static ?string $model = Producto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('descripcion')
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('imagen')
                    ->label('Imagen')
                    ->image()
                    ->directory('uploads/productos')
                    // ->imageEditor()
                    // ->imageEditorAspectRatios([
                    //     null,
                    //     '16:9',
                    //     '4:3',
                    //     '1:1',
                    // ])
                    // ->imageResizeUpscale(false)
                    ->image('50')
                    ->required(),
                Forms\Components\TextInput::make('precio')
                    ->required()
                    ->numeric(),
                    //ASignamos un select para mostrar opciones
                Forms\Components\Select::make('categoria_id')
                    //Creamos las opciones que se mostraran, tiene que ir el nombre de la relacion que creamos en el modelo que tiene que ser la tabla y la columna que vamos a traer
                    ->relationship('categorias', 'categoria')
                    ->required() 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('precio')
                    ->numeric()
                    ->sortable(),
                    //Mostramos las categoria de la tabla de categorias
                Tables\Columns\TextColumn::make('categorias.categoria')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->size(50),
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
            'index' => Pages\ListProductos::route('/'),
            'create' => Pages\CreateProducto::route('/create'),
            'edit' => Pages\EditProducto::route('/{record}/edit'),
        ];
    }
}
