<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/7
 * Time: 下午7:09
 */

namespace App\Repositories;


use App\Topic;

/**
 * Class TopicRepository
 * @package App\Repositories
 */
class TopicRepository
{
    /**
     * @param $request
     * @return mixed
     */
    public function getTopics($request)
    {
        return Topic::select(['id', 'name'])
            ->where('name', 'like', '%' . $request->query('q') . '%')
            ->get();
    }
}