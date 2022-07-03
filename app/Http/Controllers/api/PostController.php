<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
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
        $posts = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.user_id', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderby('id', 'desc')
            ->get();

        return $posts->isEmpty() ? [] : $posts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        Post::create($request->all());
        $post = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.user_id', 'users.name as user_name', 'posts.created_at', 'posts.updated_at')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->orderByDesc('posts.id')
            ->first();

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        $post->fill($request->all())->save();

        $updated = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.user_id', 'users.name as user_name')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->where('posts.id', $post->id)
            ->get();

        return $updated;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}