<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/5
 * Time: 下午10:22
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}