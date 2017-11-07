<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public function Articles()
    {
        return $this->belongsToMany(Article::class,'article_tags');
    }

}
