<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentData extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'page_title',
        'seo_info',
        'og_img',
        'cover',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function cover_image()
    {
        return $this->hasOne(Media::class, 'cover');
    }
    public function og_image()
    {
        return $this->hasOne(Media::class, 'og_img');
    }
}
