<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerrainImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'terrain_id',
        'image_path',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function terrain()
    {
        return $this->belongsTo(Terrain::class);
    }
}
