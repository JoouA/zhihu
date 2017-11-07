<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_id','question_id','body'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

}
