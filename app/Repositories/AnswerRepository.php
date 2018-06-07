<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/5/30
 * Time: 下午5:57
 */

namespace App\Repositories;



use App\Answer;

/**
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Answer::find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getAnswerCommentsById($id)
    {
        return Answer::with('comments', 'comments.user')->where('id', $id)->first();
    }
}