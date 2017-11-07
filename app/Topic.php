<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name','questions_count','bio'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public  function questions(){
        //加上withTimestamps()，就可以操作question_topic这个表的时间了
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

}
