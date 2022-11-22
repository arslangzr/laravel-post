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
                            <a href={{ route('read') }} class="btn btn-success float-end mx-4">View Posts</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
