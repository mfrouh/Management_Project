<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
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
        $notes=Note::orderby('content','asc')->select(['id','content'])->paginate(10);
        return response()->json($notes);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            ]);
        $note=new Note();
        $note->content=$request->content;
        $note->project_id=$request->project_id;
        $note->save();
        $comment=new Comment();
        $comment->comment="Add New Note ".$request->content;
        $comment->project_id=$request->project_id;
        $comment->save();
        return response()->json('created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notes=Note::where('project_id',$id)->orderby('content','asc')->select(['id','content'])->paginate(5);
        return response()->json($notes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
       $comment=new Comment();
       $comment->comment="Delete Note ".$note->content;
       $comment->project_id=$note->project_id;
       $comment->save();
       $note->delete();
       return response()->json('deleted');
    }
}
