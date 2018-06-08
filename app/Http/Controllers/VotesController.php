<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;

/**
 * Class VotesController
 * @package App\Http\Controllers
 */
class VotesController extends Controller
{
    /**
     * @var AnswerRepository
     */
    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 返回用户是否对该回答进行点赞
     */
    public function users($id)
    {
        $user = user('api');
        return response()->json(['voted' => $user->hasVotedFor($id)]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 对回答进行点赞
     */
    public function vote()
    {
        $user = user('api');
        $answer = $this->answer->byId(request('answer'));
        $voted = $user->voteFor($answer->id);
        if (count($voted['attached'])) {
            $user->increment('favorites_count');
            $answer->increment('votes_count');
            return response()->json(['voted' => true]);
        }
        $user->decrement('favorites_count');
        $answer->decrement('votes_count');
        return response()->json(['voted' => false]);
    }
}
