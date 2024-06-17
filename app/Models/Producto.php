<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class Producto extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'descripcion',
        'precio',
        'categoria_id',
        'imagen'
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
