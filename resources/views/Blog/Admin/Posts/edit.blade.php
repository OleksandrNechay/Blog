@extends('layouts.admin_layout')

@section('content')
    @php
        /** @var \App\Models\Post $item */
    @endphp
    <div class="container">
        @include('Blog.Admin.Posts.includes.result_messages')

        @if($item->exists)
            <form method="POST" action="{{ route('blog.admin.posts.update', $item->id) }}" enctype="multipart/form-data">
                @method('PATCH')
                @else
                    <form method="POST" action="{{ route('blog.admin.posts.store') }}" enctype="multipart/form-data">
                        @endif
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @include('Blog.Admin.Posts.includes.post_edit_main_col')
                            </div>
                            <div class="col-md-3">
                                @include('Blog.Admin.Posts.includes.post_edit_add_col')
                            </div>
                        </div>

                    </form>
                    @if($item->exists)
                        <br>
                        <form method="POST" action="{{ route('blog.admin.posts.destroy', $item->id) }}">
                            @method('DELETE')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card card-block">
                                        <div class="card-body ml-auto">
                                            <button type="submit" class="btn btn-link"> Видалити </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>
                        </form>
        @endif
    </div>
@endsection



