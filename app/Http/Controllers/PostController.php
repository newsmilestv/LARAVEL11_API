<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\VoidType;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'body'  => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'All fields are required',
                'errors'  => $validator->errors()
            ], 422);            
        }

        $post = Post::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Message created successfully',
            'data' => new PostResource($post)
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
}
