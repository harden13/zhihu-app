<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/7
 * Time: 下午5:42
 */

namespace App\Repositories;


use App\Comment;

/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}