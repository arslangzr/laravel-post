@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="add-post-header">
                            <span style="font-size:25px">
                                {{ __('Posts') }}
                            </span>
                            <a href={{ route('create') }} class="btn btn-primary float-end">Add Post</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                        <div class="d-flex row align-items-center posts">

                            @foreach ($posts as $post)
                                <div class="card m-4" style="width: 18rem;">
                                    <img src="{{ env('APP_URL') . '/laravel-post/storage/app/uploads/' . $post->image_path }}" class="card-img-top" alt="...">
                                    <div class="card-body" id="{{ $post->id }}">
                                        <h5 class="card-title">Post</h5>
                                        <p class="card-text">{{ $post->text }}</p>
                                        <form action="{{ route('delete',$post->id) }}" method="POST">
                                            <a href="{{ route('edit',$post->id) }}" class="btn btn-primary">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger float-end" onclick="confirm('Are you Sure you want to delete?');">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            {{ $posts->links() }}


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
