@extends('layouts.admin_layout')

@section('content')
    <div class="row">
    <div class="container-fluid px-4">
        <h1 class="mt-4">Пости категорії:  </h1>
        <ol class="breadcrumb mb-4">
            <div class="col-sm-6">

                @foreach($posts as $post)
                    <a class="list-group-item" href="{{route('blog.admin.posts.edit', $post->id)}}">
                        <p class="list-group-item-heading"> {{$post->id}}. {{$post->title}}</p>

                    </a>

                @endforeach

            </div>
        </ol>



    </div>
    </div>

@endsection
