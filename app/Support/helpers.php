<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/7
 * Time: 下午7:21
 */
if(!function_exists('user')){
    function user($driver = null){
        if($driver){
            return app('auth')->guard('api')->user();
        }
        return app('auth')->user();
    }
}