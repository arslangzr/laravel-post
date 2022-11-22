@extends('layouts.app')
@section('content')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn").attr("disabled", true);

            $("input:radio").change(function() {
                $(".btn").attr("disabled", false);
            });
        });
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="add-post-header">
                            <span style="font-size:25px">
                                {{ __('Select an image') }}
                            </span>

                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container d-flex flex-row justify-content-between">

                            <div class="card m-5" style="width: 18rem;">
                                <img src="{{ env('APP_URL') . '/laravel-post/storage/app/uploads/' . $fileName_with_background_full }}"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">Before Removing Background</p>
                                </div>
                            </div>

                            <div class="card m-5" style="width: 18rem;">
                                <img src="{{ env('APP_URL') . '/laravel-post/storage/app/uploads/' . $fileName_without_background_full }}"
                                    class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="card-text">After removing background</p>
                                    {{-- <p class="card-text">{{ env('APP_URL')."/laravel-post/storage/app/uploads/".$fileName_with_background_full }}</p> --}}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('submit_image') }}" method="post">
                            @csrf
                            <div class="d-flex flex-row">
                                <input type="hidden" name="file_with_background" value="{{ $fileName_with_background_full }}" />
                                <input type="hidden" name="post_text" value="{{ $text }}" />
                                <input type="hidden" name="file_without_background" value="{{ $fileName_without_background_full }}" />

                                <input style="display: inline-block; width: 6em;margin-left: 34px;" type="radio"
                                    name="background_selection" id="withBackground" value="withBackground">With
                                Background<br>
                                <input style="display: inline-block; width: 6em;margin-left: 236px;" type="radio"
                                    name="background_selection" id="withoutBackground" value="withoutBackground">Without
                                Background<br>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
