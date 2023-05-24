@extends('layouts.master')

@section('page-header')
<div class="container">
<br>
<h1>Shorten URLs</h1>
<br>
<br>
</div>
@endsection


@section('content')
<div class="container">

<form method="post" action="/create_link" class="form">
    @csrf
    <input type="text" name="link">
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
        <th scope="col">Link</th>
        <th scope="col">shortenURL</th>
        <th scope="col">clicks</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>

        @foreach ($links as $link )

        <tr>
            <td>{{$link->id}}</td>
            <td>{{$link->link}}</td>
            <td><a href="{{ route('sLink', $link->id) }}">{{ $link->short_link }}</a></td>
            <td>{{$link->clicks}}</td>
            <td>
                {{-- <a href="{{route('create_link',$link->id)}}" class="btn btn-primary btn-sm">Edit</a> --}}
            </td>

            <td>
                <form method="post" action="/delete_l" class="form">
                    @csrf
                    <input type="hidden" name="id" value="{{ $link->id }}">
                    {{-- {{ $link->id }} --}}
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
          </tr>


        @endforeach



    </tbody>
  </table>
</div>
</div>
</div>

@endsection
