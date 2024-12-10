<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Image extends Model
{
    protected $table = 'images';
    protected $guarded = ['id'];


    public function ic(): HasOne
    {
        return $this->hasOne(IC::class, 'image');
    }

    public function blogDiagramOf(): HasOne
    {
        return $this->hasOne(IC::class, 'blog_diagram');
    }
}
