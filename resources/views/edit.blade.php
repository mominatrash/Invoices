@extends('layouts.master')

@section('page-header')
<br>
<h1>Edit</h1>
<br><br>
@endsection

@section('content')
<form method="post" action="{{route('update')}}" class="form">
    @csrf
    <input type="hidden" name="id" value="{{$edit->id}}">
    <input type="text" name="name" value="{{$edit->name}}">
    <button type="submit" class="btn btn-success btn-sm" >Submit</button>

</form>

</div>
</div>
@endsection
