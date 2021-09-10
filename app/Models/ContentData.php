<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentData extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_id',
        'path',
        'page_title',
        'seo_info',
        'og_img',
        'cover',
        'updated_at',
    ];
    protected $hidden = [
        'created_at',
    ];
}
