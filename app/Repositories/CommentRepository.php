<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/7/11
 * Time: 21:38
 */

namespace App\Repositories;


use App\Comment;

class CommentRepository
{
    public function create(array $arrtibute)
    {
        return Comment::create($arrtibute);
    }
}