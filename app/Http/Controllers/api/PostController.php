<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\PostRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.image', 'posts.image_name', 'posts.user_id', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderby('id', 'desc')
            ->get();

        $response = $posts->isEmpty() ? [] : $posts;
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // ローカル環境に保存する場合、API側でBase64に変換する場合はImageServiceを作成する
        // $base64Image = ImageService::handleBase64($request->image, $request->fileName);

        // DBに保存
        $post = new Post;
        $post->fill($request->all())->save();

        $post = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.image', 'posts.image_name', 'posts.user_id', 'users.name as user_name', 'posts.created_at', 'posts.updated_at')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderByDesc('posts.id')
            ->first();

        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        // ローカル環境に保存する場合、API側でBase64に変換する場合はImageServiceで処理する
        // $base64Image = ImageService::handleBase64($request->image, $request->fileName);

        $post = Post::find($id);

        $post->fill($request->all())->update();

        $updated = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.image', 'posts.image_name', 'posts.user_id', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.id', $id)
            ->get();

        return response()->json($updated, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json(['id' => $id], 200);
    }
}