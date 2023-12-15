<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use App\Models;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Support\RawJs;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reposession extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'id',
        'name',
    ];

    protected $casts = [
        "colors" => "json",
    ];



}
