<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable  = ['title','body','user_id'];

//    public function

    public  function topics()
    {
        // withTimestamps() 是操作question_topic的时间片段  多对多后面要加一张表 如果用laravel提供的便利创建表 也可以不加表名
        return $this->belongsToMany(Topic::class,'question_topic')->withTimestamps();
    }

    public function user()
    {
        // user和question是一对多的关系 user_id是question表中的数据
        return $this->belongsTo('App\User','user_id');
    }

    // scope 这是laravel提供的一个方法
    public function scopePublished($query)
    {
        // 如果is_hidden是F的话  是可以显示的
//        return $query->where('is_hidden','=','F');
        return $query->whereIsHidden('F');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'user_question')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }
}
