<?php

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Http\Request;
use Session;
class CaptchaController extends Controller
{
    /**
     * This is to get a valid pic and show on
     */
    public function captcha()
    {
        $builder = new CaptchaBuilder();

        $builder->build(115,35);

        Session::flash('validTag',$builder->getPhrase());

        header('Content-type: image/jpeg');

        $builder->output();

    }
}
