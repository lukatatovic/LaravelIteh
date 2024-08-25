<?php

namespace App\Http\Controllers;

use App\Http\Resources\Friend\FriendCollection;
use App\Http\Resources\Friend\FriendResource;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $friends = Friend::all();
        if (is_null($friends)) {
            return response()->json('No friends found', 404);
        }
        return response()->json(new FriendCollection($friends));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $friend = Friend::create([
            'name' => $request->name,
            'gender' => $request->gender
        ]);

        return response()->json([
            'Friend inserted' => new FriendResource($friend)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function show($friend_id)
    {
        $friend = Friend::find($friend_id);
        if (is_null($friend)) {
            return response()->json('Friend not found', 404);
        }
        return response()->json(new FriendResource($friend));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend $friend)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $friend->name = $request->name;
        $friend->gender = $request->gender;

        $friend->save();

        return response()->json([
            'Friend updated' => new FriendResource($friend)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friend $friend)
    {
        $friend->delete();
        return response()->json('Friend removed');
    }
}
