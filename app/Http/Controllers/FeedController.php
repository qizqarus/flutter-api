<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Like;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feeds = Feed::with('user')->latest()->get();
        return response([
            'feeds' => $feeds
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request->validated();

        auth()->user()->feeds()->create([
            'content' => $request->content,
        ]);

        return response([
            'message'   => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function likePost($feed_id)
    {
        $feed = Feed::whereId($feed_id)->first();

        if(!$feed)  {
            return responce([
                'message'   => '404 Not Found'
            ], 500);
        }

        $unliked_post = Like::where('user_id', auth()->id())->where('feed_id', $feed_id)->delete();
        if($unliked_post) {
            return response([
                'message'   => 'Unliked'
            ], 200);
        }

        $like_post = Like::create([
            'user_id' => auth()->id(),
            'feed_id' => $feed_id
        ]);
        if($like_post) {
            return response([
                'message'   => 'Liked'
            ], 200);
        }
    }

    public function comment(Request $request, $feed_id)
    {
        $request->validate([
            'body'  =>  'required'
        ]);

        $comment = Comment::create([
            'user_id'   =>  auth()->id(),
            'feed_id'   => $feed_id,
            'body'  =>  $request->body
        ]);

        return  response([
            'message'   =>  'success'
        ], 201);
    }

    public function getComments($feed_id)
    {
        $comments = Comment::whereFeedId($feed_id)->with('user', 'feed')->latest()->get();

        return response([
            'comments'  =>  $comments
        ], 200);
    }
}
