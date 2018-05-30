<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use App\Topic;
use Illuminate\Http\Request;
use Auth;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "12";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->normalizeTopic($request->get('topics'));
        $data = [
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
            'user_id'=>Auth::id()
        ];

        $question = Question::create($data);

        $question->topics()->attach($topics);
        return redirect()->route('questions.show', ['id'=>$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('id', $id)->with('topics')->first();
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 标签检查
     * @param array $topics
     * @return array
     */
    private function normalizeTopic(array $topics)
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
}
