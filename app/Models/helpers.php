<?php
/**
 * Created by PhpStorm.
 * User: Deelko 1
 * Date: 8/25/2021
 * Time: 4:27 PM
 */

    if (! function_exists('setting')){
        function setting($title)
        {
            $config = \App\Models\Config::where('config_title',$title)->first()->value;
            return $config;
        }
    }
