<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','api_token','settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // 用户和问题是一对多的关系
    public function questions(){
        return $this->hasMany(Question::class);
    }

    protected $casts = [
        'settings' => 'array'
    ];


    // 判断问题是不是属于当前用户
    public function owns(Model $model){
        return $this->id == $model->user_id;
    }

    public function answers(){
        return $this->hasMany('App\Answer');
    }

    public function follows(){
        /*return Follow::create([
            'question_id' => $question,
            'user_id' => $this->id
        ]);*/

        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    // followThis的功能就是对问题进行单击后 进行关注 在单击取消关注 就是对数据中的数据进行插入删除的操作
    public function followThis($question){
        return $this->follows()->toggle($question);
    }

    // 判断user_question表中question_id的数量
    public function followed($question){
        // !! 取反再取反返回一个bool值
        return !! $this->follows()->where('question_id',$question)->count();
    }


    public function  followers(){
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
    }

    public function  followersUser(){
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    public function followThisUser($user){
        return $this->followers()->toggle($user);
    }


    public function votes(){
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps(); //如果你创建的表是user_answer的话，来对应user和answer之间的关系 这个后面可以不加表votes
    }

    public function voteFor($answer){
        // $answer 指的是answer的id
        return $this->votes()->toggle($answer);
    }

    public function hasVotedFor($answer){
         return !! $this->votes()->where('answer_id',$answer)->count();
    }

    public function messages(){
        return $this->hasMany(Message::class,'to_user_id');
    }

    public function settings()
    {

        return new Setting($this);
    }

    public function favorites(){

        return $this->belongsToMany('App\pic','favorites')->withTimestamps();
    }

}
