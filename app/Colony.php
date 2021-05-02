<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colony extends Model
{
	use SoftDeletes;

    protected $fillable = ['name', 'slug', 'state', 'zip_id'];

    public function zip() {
        return $this->belongsTo(Zip::class);
    }

    public function sections() {
        return $this->belongsToMany(Section::class)->withTimestamps();
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
