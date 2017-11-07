<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/7/20
 * Time: 9:49
 */

namespace App;


class Setting
{
    protected $user;

    protected $allowed = ['name','bio','live'];

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function merge(array $attributes)
    {
        $settings = array_only($attributes,$this->allowed);

        if (!empty(trim($settings['name']))){
            return $this->user->update(compact('settings'));
        }else{
            return false;
        }

    }
}