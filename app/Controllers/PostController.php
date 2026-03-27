<?php
 namespace App\Controllers;
    use App\Controller;
use App\Models\Post;

    class PostController extends Controller
    {
        public function index()
        {
        $posts=Post::all();
        return view('tintuc.tintuc',compact('posts'));
        }

    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            header('HTTP/1.0 404 Not Found');
            echo 'Bài viết không tồn tại';
            exit();
        }

      $viewpost=$post->views+1;
        $newViews = $viewpost;

        // Cập nhật lượt xem vào database
        Post::where('id', $id)->update(['views' => $newViews]);

        // Cập nhật lại giá trị cho biến $post để hiển thị trên view
        $post->views = $newViews;

        return view('tintuc.chitiet', compact('post'));
    }
    }
?>