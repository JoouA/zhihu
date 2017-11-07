<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/6/26
 * Time: 0:14
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id){
        return User::find($id);
    }
}