<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagetype extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
