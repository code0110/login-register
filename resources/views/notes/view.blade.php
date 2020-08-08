
@extends('layouts.app')

@section('content')
<div class="row">
  <div class="container">
<div class="col-sm-12">
    <h1 class="display-3">Notes</h1>  

    <div class="col-sm-12">

  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div>
  @endif
</div>  
    <div>
    <a style="margin: 19px;" href="{{ route('notes.create')}}" class="btn btn-primary">New note</a>
    </div>  
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Name</td>
          <td>Email</td>
          <td>Job Title</td>
          <td>City</td>
          <td>Country</td>
          <td colspan = 2>Actions</td>
        </tr>
    </thead>
    <tbody>
        @foreach($notes as $note)
        <tr>
            <td>{{$note->id}}</td>
            <td>{{$note->first_name}} {{$note->last_name}}</td>
            <td>{{$note->email}}</td>
            <td>{{$note->job_title}}</td>
            <td>{{$note->city}}</td>
            <td>{{$note->country}}</td>
            <td>
                <a href="{{ route('notes.edit',$note->id)}}" class="btn btn-primary">Edit</a>
            </td>
            <td>
                <form action="{{ route('notes.destroy', $note->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div>
</div>
</div>
@endsection


