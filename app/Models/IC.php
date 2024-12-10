<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class IC extends Model
{
    protected $table = 'ics';
    protected $guarded = ['id'];

    public function store() : BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function truthTables() : HasMany
    {
        return $this->hasMany(TruthTable::class, 'ic_id', 'id');
    }

    public function mainImage() : BelongsTo
    {
        return $this->belongsTo(Image::class, 'image');
    }

    public function blogDiagram(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'blog_diagram');
    }
}
