<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location', 'parent_id', 'name',
    ];

    /**
     *
     */
    public function parent()
    {
        $this->hasOne('App\Page', 'parent_id');
    }
}
