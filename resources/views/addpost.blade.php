<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CDN for Jquery and Webcam -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>


    <main>
        @extends('layouts.app')

        @section('content')
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="add-post-header">
                                    <span style="font-size:25px">
                                        {{ __('Add post') }}
                                    </span>
                                    <a href="{{ route('home') }}" class="btn btn-danger mx-1 float-end">Cancel</a>
                                </div>
                            </div>

                            <div class="card-body">
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form action="{{ route('add') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="post-text">Post Text</label>
                                        <textarea class="form-control" id="post-text" rows="3" name="text"></textarea>
                                    </div>
                                    <a class="btn btn-primary my-4" id="webcam">Open Webcam</a>
                                    <div id="webcam-panel" class="form-group my-2">
                                        <label for="post-image">Image</label>
                                        <br>
                                        <div class="col-md-6">

                                            <div id="my_camera"></div>

                                            <br />

                                            <input id="capture_button" type=button value="Take Snapshot">

                                            <input type="hidden" name="image" class="image-tag">

                                        </div>

                                        <div class="col-md-6">

                                            <div id="results">Your captured image will appear here...</div>

                                        </div>
                                                                       {{-- <input type="file" class="form-control-file" id="post-image" name="file"> --}}
                                    </div>
                                    <button type="submit" class="btn btn-success my-4 float-end">Submit</button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
    </main>
    </div>
    <script language="JavaScript">
        $(document).ready(function() {
            $("#webcam-panel").hide();
            $("#webcam").on('click', function() {
                $(this).hide();
                $("#webcam-panel").show();

                Webcam.set({

                    width: 490,

                    height: 350,

                    image_format: 'jpeg',

                    jpeg_quality: 90

                });

                Webcam.attach('#my_camera');
                // $("#webcam-panel").hide();
                // $("#webcam").click(function(){
                //     console.log("Clicked");
                // //     $("#webcam-panel").show();
                // });


                $("#capture_button").click(function() {
                    Webcam.snap(function(data_uri) {

                        $(".image-tag").val(data_uri);

                        // document.getElementById('results').innerHTML = '<img src="' +
                        //     data_uri + '"/>';
                        document.getElementById('results').innerHTML = `<img src="${data_uri}"/>`;

                    });
                });

            });
        });
    </script>
</body>

</html>
