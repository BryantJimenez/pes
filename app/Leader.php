<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $fillable = ['leader_id', 'user_id', 'rol'];

    public function leader() {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
