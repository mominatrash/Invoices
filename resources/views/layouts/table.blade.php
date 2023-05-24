@extends('layouts.master')

@section('page-header')
<div class="container">
<br>
<h1>Incoives Table</h1>
<br>
<br>
</div>
@endsection

@section('content')
<div class="container">

<form method="post" action="/insert" class="form">
    @csrf
    <input type="text" name="name">
    <button type="submit"  class="btn btn-dark btn-sm" >Submit</button>

</form>
</div>
<br>
<br>
<div class="container">
<table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>

        @foreach ($invoices as $inv )

        <tr>
            <td>{{$inv->id}}</td>
            <td>{{$inv->name}}</td>
            <td>
                <a href="{{route('edit',$inv->id)}}" class="btn btn-primary btn-sm">Edit</a>
            </td>

            <td>
                <form method="post" action="/delete" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $inv->id }}">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>


        @endforeach



    </tbody>
  </table>
</div>
</div>
</div>

@endsection
