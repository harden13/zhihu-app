<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/5/30
 * Time: 上午11:09
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

/**
 * Class QuestionRepository
 * @package App\Repositories
 */
class QuestionRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id', $id)->with(['topics', 'answers'])->first();
    }

    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    /**
     * @param array $topics
     * @return array
     */
    public function normalizeTopic(array $topics)
    {
        $ids = Topic::pluck('id');

        $ids = collect($topics)->map(function ($topic) use ($ids){
            if (is_numeric($topic) && $ids->contains($topic)) {
                //如果是数字，并且数据库中存在记录
                return (int) $topic;
            } else {
                //如果是数字，并且数据库中不存在记录或者不是数字
                return Topic::create(['name'=>$topic])->id;
            }
        })->toArray();
        Topic::whereIn('id', $ids)->increment('questions_count');
        return $ids;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Question::findOrFail($id);
    }

    /**
     * @return mixed
     */
    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getQuestionCommentsById($id)
    {
        return Question::with('comments', 'comments.user')->where('id', $id)->first();
    }
}