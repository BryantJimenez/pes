<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zip extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'slug', 'state'];

    public function colonies() {
        return $this->hasMany(Colony::class);
    }
}
