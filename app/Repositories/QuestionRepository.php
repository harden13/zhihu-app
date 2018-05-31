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

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

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

    public function byId($id)
    {
        return Question::findOrFail($id);
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }
}