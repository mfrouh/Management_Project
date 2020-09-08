@extends('layouts.app')
@section('title')
   {{$project->name}}
@endsection
@section('content')
<div class='container-fluid' id="note">
    <project :project ="{{$project}}"></project>
</div>
@endsection
