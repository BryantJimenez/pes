<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'slug', 'state'];

    public function colonies() {
        return $this->belongsToMany(Colony::class)->withTimestamps();
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
