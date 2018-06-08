<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

/**
 * Class QuestionFollowController
 * @package App\Http\Controllers
 */
class QuestionFollowController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $question;

    /**
     * QuestionFollowController constructor.
     * @param QuestionRepository $question
     */
    public function __construct(QuestionRepository $question)
    {
        $this->middleware('auth');
        $this->question=$question;
    }

    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     * 关注某问题
     */
    public function follow($question)
    {
        user()->followThis($question);

        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 判断用户是否关注了该问题
     */
    public function follower(Request $request)
    {
        $user = user('api');
        $followed = $user->followed($request->get('question'));
        if ($followed) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 关注某问题
     */
    public function followThisQuestion(Request $request)
    {
        $user = user('api');
        $question = $this->question->byId($request->get('question'));
        $followed = $user->followThis($question->id);
        if (count($followed['detached']) > 0) {
            //取消关注
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
