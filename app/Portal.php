<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers()
    {
        return $this->belongsToMany('App\User', 'portal_teacher', 'portal_id', 'teacher_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students()
    {
        return $this->belongsToMany('App\User', 'portal_student', 'portal_id', 'student_id');
    }
}
