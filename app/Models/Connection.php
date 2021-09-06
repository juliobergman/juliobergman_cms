<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'section',
        'content',
        'public',
        'oby',
        'updated_at',
    ];
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function cover_image()
    {
        return $this->hasOneThrough(Media::class, ContentData::class, 'cover', 'id','cover','cover');
    }
    public function og_image()
    {
        return $this->hasOneThrough(Media::class, ContentData::class, 'og_img', 'id','og_img','og_img');
    }
}
