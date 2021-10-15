<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'media_category_id',
        'name',
        'subtitle',
        'path',
    ];

    protected $hidden = [
        'updated_at',
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
        return $this->hasOneThrough(
            Media::class,
            ContentData::class,
            'cover',
            'id',
            'cover',
            'cover'
        )->withDefault($this->image_defaults);
    }

    public function album()
    {
        return $this->belongsTo(MediaCategory::class, 'media_category_id');
    }

}
