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
                                        {{ __('Edit post') }}
                                    </span>
                                    <a href="{{ route('home') }}" class="btn btn-danger mx-1 float-end">Cancel</a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form action="{{ route('update',$posts->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- {{ method_field('put') }} --}}
                                    <div class="form-group">
                                        <img src="{{ env('APP_URL') . '/laravel-post/storage/app/uploads/' . $posts->image_path }}" class="mx-auto d-block" alt="...">
                                        <label for="post-text">Post Text</label>
                                        <textarea class="form-control" id="post-text" rows="3" name="text">{{ $posts->text }}</textarea>
                                        <input type="radio" name="browseImage" id="imgBrowse">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cameraImage" id="imgCamera">
                                            <input  type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                              Default radio
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                            <label class="form-check-label" for="flexRadioDefault2">
                                              Default checked radio
                                            </label>
                                          </div>
                                        <input type="file" class="form-control-file" id="post-image" name="file">

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
