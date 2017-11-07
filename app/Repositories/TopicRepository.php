<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/7/11
 * Time: 22:11
 */

namespace App\Repositories;

use App\Topic;
use Illuminate\Http\Request;


class TopicRepository
{
    public function getTopicsForTagging(Request $request)
    {
        $topics = Topic::select(['id','name'])->where('name','like','%'.$request->input('q').'%')->get();

        return $topics;
    }

}