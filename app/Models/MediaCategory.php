<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:M d, Y',
        'updated_at' => 'datetime:M d, - Y h:m a',
    ];

    public function files()
    {
        return $this->hasMany(Media::class,'category_id');
    }

    public function content(){
        return $this->hasOne(Content::class, 'media_category_id');
    }

    public function connection(){
        return $this->hasManyThrough(Connection::class, Content::class);
    }

}
