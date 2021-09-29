<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'section_id',
        'content_id',
        'public',
        'oby',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected $image_defaults = [
        'name' => null,
        'fullsize' => '/storage/factory/stock/cover-placeholder/fullsize.jpg',
        'xlarge' => '/storage/factory/stock/cover-placeholder/xlarge.jpg',
        'large' => '/storage/factory/stock/cover-placeholder/large.jpg',
        'medium' => '/storage/factory/stock/cover-placeholder/medium.jpg',
        'thumbnail' => '/storage/factory/stock/cover-placeholder/thumbnail.jpg',
    ];


    public function cover_image()
    {
        // return $this->hasOneThrough(Media::class, ContentData::class, 'cover', 'id','cover','cover')->withDefault($this->image_defaults);
        return $this->hasOneThrough(Media::class, ContentData::class, 'cover', 'id','cover','cover')->withDefault($this->image_defaults);
    }
    public function og_image()
    {
        return $this->hasOneThrough(Media::class, ContentData::class, 'og_img', 'id','og_img','og_img')->withDefault($this->image_defaults);
    }
}
