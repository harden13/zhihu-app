<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Repositories\AnswerRepository;
use Auth;

class VotesController extends Controller
{
    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    public function users($id)
    {
        $user = Auth::guard('api')->user();
        return response()->json(['voted' => $user->hasVotedFor($id)]);
    }

    public function vote()
    {
        $user = Auth::guard('api')->user();
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
