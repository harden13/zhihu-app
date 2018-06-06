<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/5/30
 * Time: 下午5:57
 */

namespace App\Repositories;



use App\Answer;

class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }
}