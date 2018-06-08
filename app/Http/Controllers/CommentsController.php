<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use App\Repositories\QuestionRepository;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{

    /**
     * @var AnswerRepository
     */
    protected $answer;
    /**
     * @var QuestionRepository
     */
    protected $question;
    /**
     * @var CommentRepository
     */
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $answer
     * @param $question
     * @param $comment
     */
    public function __construct(AnswerRepository $answer, QuestionRepository $question, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->question = $question;
        $this->comment = $comment;
    }

    /**
     * @param $id
     * @return mixed
     * 返回该回答的评论
     */
    public function answer($id)
    {
        $answer = $this->answer->getAnswerCommentsById($id);
        return $answer->comments;
    }

    /**
     * @param $id
     * @return mixed
     * 返回该问题的评论
     */
    public function question($id)
    {
        $question = $this->question->getQuestionCommentsById($id);
        return $question->comments;
    }

    /**
     * @return static
     * 保存对问题或者回答的评论
     */
    public function store()
    {
        $model = $this->getModelNameFromType(request('type'));
        return $this->comment->create([
            'commentable_id' => request('model'),
            'commentable_type' => $model,
            'user_id' => user('api')->id,
            'body' => request('body')
        ]);
    }

    /**
     * @param $type
     * @return string
     */
    public function getModelNameFromType($type)
    {
        return $type === 'question' ? 'App\Question' : 'App\Answer';
    }
}
