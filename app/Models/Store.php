<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $table = 'stores';
    protected $guarded = ['id'];

    public function ic() : HasMany
    {
        return $this->hasMany(IC::class);
    }
}
