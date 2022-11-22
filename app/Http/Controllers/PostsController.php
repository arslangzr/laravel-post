<?php

namespace App\Http\Controllers;

use HttpRequest;
use HttpException;
use App\Models\Posts;
// use App\Http\Requests;
use http\QueryString;
use http\Message\Body;
use Illuminate\Support\Facades\URL;
use Spatie\FlareClient\Http\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StorePostsRequest;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\UpdatePostsRequest;
use Symfony\Component\HttpFoundation\Request;
use League\CommonMark\Environment\Environment;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Posts::orderBy('created_at', 'desc')->paginate(100);
        return view("view", compact('posts'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        return view("test");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function image()
    // {
    //     return view("img_background");
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("addpost");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $current_user_id = Auth::user()->id;
        $img = $request->image;
        $folderPath = "uploads/";
        $image_parts = explode(";base64,", $img);
        // echo "image_base64=".$replace_slashes;
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $extension = '.png';
        $fileName = uniqid() . "_temp";
        $unique = uniqid();
        $fileName_with_background_full = $unique . "_temp" . $extension;
        $fileName_without_background_full = $unique . "_rembg" . $extension;
        $file_with_background_path = $folderPath . $fileName_with_background_full;
        $file_without_background_path = $folderPath . $fileName_without_background_full;
        Storage::put($file_with_background_path, $image_base64);
        $storage_path = Storage::path('uploads\\');
        $image_storage_path_with_background = $storage_path . $fileName_with_background_full;
        $image_storage_path_without_background = $storage_path . $fileName_without_background_full;

        // executing remove background commandline
        $shell_command = shell_exec('rembg i ' . $image_storage_path_with_background . " " . $image_storage_path_without_background);
        $text = $request->get('text');
        // dd($shell_command);
        // dd($image_storage_path_without_background, $image_storage_path_with_background);
        // echo 'Image uploaded successfully: '. $image_storage_path_with_background;







        // $request->validate([
        //     "text" => 'required',
        // ]);

        // if ($request->hasFile('file')) {
        //     $image = $request->file('file');
        //     $teaser_image = $image->getClientOriginalName();
        //     $destinationPath = public_path('/images/image_post');
        //     $image->move($destinationPath, $teaser_image);
        // }


        // $post = new Posts([
        //     "text" => $request->get('text'),
        //     "image_path" => $fileName_with_background_full,
        //     "posted_by" => Auth::user()->id
        // ]);
        // dd($post);
        // $post->save();
        return view("img_background", compact('fileName_with_background_full', 'fileName_without_background_full', 'text'));

        // return view('home');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function submitImage(Request $request)
    {
        $user_id = "1";
        $user_name = "user";
        $selection = $request->background_selection;
        $post_text = $request->get('post_text');
        $image_file = "";
        $no_bg_file_path = storage_path('app\uploads\\' . $request->file_without_background);
        $with_bg_file_path = storage_path('app\uploads\\' . $request->file_with_background);
        if ($selection === "withoutBackground") {
            $image_file = $request->file_without_background;
            if (file_exists($with_bg_file_path)) {
                unlink($with_bg_file_path);
            } else {
                echo "Image file " . $with_bg_file_path . " does not exist or is not readable";
            }
        } elseif ($selection === "withBackground") {
            $image_file = $request->file_with_background;
            if (file_exists($with_bg_file_path)) {
                unlink($no_bg_file_path);
            } else {
                echo "image file " . $no_bg_file_path . " does not exist or is not readable";
            }
        } else {
            echo ("invalid selection");
        }
        $post = new Posts([
            "text" => $post_text,
            "image_path" => $image_file,
            "posted_by" => Auth::user()->id
        ]);

        // dd($image_file, $no_bg_file_path, $with_bg_file_path, $request, $post_text, Storage::url('file'));
        $post->save();
        return redirect()->route('home')->with('status', 'Post Added succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        return 'show function called';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = Posts::find($id);
        // dd($posts);
        return view('editpost', compact('posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostsRequest  $request
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Posts $posts, $id)
    {
        $file = $request->file("file");
        $filename = $request->file("file")->getClientOriginalName();
        $destinationPath = public_path('/images/image_post');
        $file->move(Storage::path('uploads\\'),$file->getClientOriginalName());
        $text = $request->text;

        $post = Posts::find($id);
        $post->text = $request->text;
        $post->image_path=$filename;
        $post->save();

        return redirect()->route('read')->with('status', 'Post updated succesfully');

        // dd($request, $id, $request->text, $request->file("file")->getClientOriginalName(), Storage::path('uploads\\'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        $post->delete();

        return redirect()->route('read')->with('status', 'Post deleted succesfully');
    }
}
