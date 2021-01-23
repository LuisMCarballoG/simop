<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    public static function str_random(){
        $S = "";
        $P = "1234567890ABCDEFGHIJKLMNOPQRSTVWXYZabcdefghijklmnopqrstuvwxyz_";
        $i = 0;
        while($i < 50){
            $char = substr($P, mt_rand(0, strlen($P)-1),1);
            $S .= $char;
            $i++;
        }
        return $S;
    }

    public static function str_id(){
        $S = "";
        $P = "1234567890";
        $i = 0;
        while($i < 10){
            $char = substr($P, mt_rand(0, strlen($P)-1),1);
            $S .= $char;
            $i++;
        }
        return $S;
    }
}