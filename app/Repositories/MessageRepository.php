<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/6
 * Time: 下午10:39
 */

namespace App\Repositories;


use App\Message;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }
}