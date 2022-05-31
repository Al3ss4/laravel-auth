
@extends('layouts.dashboard')

@section('content')


<div class="container">
    <table class="table">
        <thead>
          <tr>
            
            <th scope="col">Titolo</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post )
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>{{$post->title}}</td>
                    <td>
                        <a href="{{route('admin.posts.create', ['post' => $post->id])}}" class="btn btn-primary">New</a>
                        <a href="{{route('admin.posts.show', ['post' => $post->id])}}" class="btn btn-primary">Show</a>
                        <a href="{{route('admin.posts.edit', ['post' => $post->id])}}" class="btn btn-warning">Edit</a>
                        <form action="" method="post" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            @endforeach


        </tbody>
    </table>
</div>




@endsection
