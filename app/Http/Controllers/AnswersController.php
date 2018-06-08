<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;

/**
 * Class AnswersController
 * @package App\Http\Controllers
 */
class AnswersController extends Controller
{

    /**
     * @var AnswerRepository
     */
    protected $answerRepository;

    /**
     * AnswersController constructor.
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @param StoreAnswerRequest $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     * 保存用户对问题的评论
     */
    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answerRepository->create([
           'question_id' => $question,
            'user_id' => user()->id,
            'body' => $request->get('body')
        ]);

        $answer->question()->increment('answers_count');
        $answer->user()->increment('answers_count');

        return back();
    }
}
