<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
    }
    public function index()
    {
        $tasks=Task::orderby('content','asc')->select(['id','content','complete'])->paginate(5);
        return response()->json($tasks);
    }

    public function complete($id)
    {
        $task=Task::find($id);
        $task->complete=$task->complete=='true'?'false':'true';
        $task->save();
        $comment=new Comment();
        $comment->comment=$task->complete=='true'?"Complete Task ".$task->content:"UnComplete Task ".$task->content;
        $comment->project_id=$task->project_id;
        $comment->save();
        return response()->json('changed');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'content'=>'required|min:3',
            'complete'=>"required"
            ]);
        $task=new Task();
        $task->content=$request->content;
        $task->complete=$request->complete;
        $task->project_id=$request->project_id;
        $task->save();
        $comment=new Comment();
        $comment->comment="New Task ".$task->content;
        $comment->project_id=$task->project_id;
        $comment->save();
        return response()->json('created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks=Task::where('project_id',$id)->orderby('content','asc')->select(['id','content','complete'])->paginate(5);
        return response()->json($tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
       $comment=new Comment();
       $comment->comment="Delete Task ".$task->content;
       $comment->project_id=$task->project_id;
       $comment->save();
       $task->delete();
       return response()->json('delete');
    }
}
