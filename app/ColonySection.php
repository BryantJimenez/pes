<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColonySection extends Model
{
    protected $table = 'colony_section';

    protected $fillable = ['colony_id', 'section_id'];
}
