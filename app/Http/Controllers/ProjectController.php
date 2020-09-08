<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $projects=Project::where('user_id',auth()->user()->id)->orderby('content','asc')->select(['id','content','name','url'])->paginate(6);
        return response()->json($projects);
    }
    public function comments($id)
    {
        $comments=Comment::where('project_id',$id)->orderby('created_at','desc')->take(5)->get();
        return response()->json($comments);
    }

    public function projects()
    {
        return view('projects');
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
            'name'=>"required",
            'url'=>'required'
            ]);
        $project=new Project();
        $project->content=$request->content;
        $project->user_id=auth()->user()->id;
        $project->name=$request->name;
        $project->url=$request->url;
        $project->save();
        $comment=new Comment();
        $comment->comment="Create Project ".$project->name;
        $comment->project_id=$project->id;
        $comment->save();
        return response()->json('created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $p=Project::where('id',$project->id)->select(['id','content','name','url'])->first();
        return view('project')->with('project',$p);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json('delete');
    }
}
