@extends('layouts.dashboard')
@section('content')

<div class="container">
    <div class="card">
        <h2 class="p-3">In dettaglio</h2>
        <div class="card-header">
            {{$post->id}}
        </div>
        <div class="card-body">
          <h5 class="card-title"> {{ $post->title }}</h5>
          <p class="card-text"> {{$post->content}}</p>
          <p class="card-text"> {{$post->slug}}</p>
        </div>

        <div class="p-3">
            <a href="{{route('admin.posts.index')}}" class="btn btn-primary">Torna indietro</a>
        </div>
    </div>
</div>




@endsection()

