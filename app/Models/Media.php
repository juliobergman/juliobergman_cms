<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alt',
        'info',
        'category_id',
        'public_path',
        'storage_path',
        'fullsize',
        'xlarge',
        'large',
        'medium',
        'thumbnail',
        'oby',
        'public',
        'created_at',
        'updated_at',
    ];
}
