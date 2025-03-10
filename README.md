# LARAVEL_11_API
# TIME: 06:26

# STEP 1
```php artisan install:api```

# STEP 2 
```php artisan make:controller PostController --api```

# STEP 3
```php artisan make:model Post -m```

# STEP 4 database/migrations/2025_03_05_083403_create_posts_table.php
```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```

# STEP 5 
```php artisan migrate```

# STEP 6 app/Http/Controllers/PostController.php

```
public function store(Request $request): JsonResponse
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

            $post = Post::create($request->all());

            return response()->json([
                'status'  => true,
                'message' => 'Message created successfully',
                'data'    => $post
            ], 201);
        }
    }
```
# STEP 7 routes/api.php
```Route::apiResource('posts', PostController::class);```

# STEP 8 app/Models/Post.php
```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $fillable = ['title', 'body'];
}

```
# STEP 10 Add POST Create(Store) Post JSON
```127.0.0.1:8000/api/posts```

* Add this text into body
```
{
  "title": "First Post Title",
  "body": "First Post Body"
}
```
# STEP 11 Created Resource [app/Http/Resources/PostResource.php] created successfully.
```php artisan make:resource PostResource```

```
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->id,
            'post_title' => $this->title,
            'post_body' => $this->body,
        ];
    }
}

```

# STEP 12 Change code in public function toArray(Request $request): array; app/Http/Controllers/PostController.php
```
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
```

# STEP 13 
* Add this text into body
```
{
  "title": "Second Post Title",
  "body": "Second Post Body"
}
```
* Answer
```
{
  "status": true,
  "message": "Message created successfully",
  "data": {
    "post_id": 2,
    "post_title": "Second Post Title",
    "post_body": "Second Post Body"
  }
}
```
# STEP 14 app/Http/Controllers/PostController.php
```
/**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status'  => false,
                'message' => 'Post Not Found!'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Post retrieved successfully!',
            'data' => new PostResource($post)
        ]);
    }
```
# STEP 15 Add new route GET 127.0.0.1:8000/api/posts/1

# STEP 16 Updated app/Http/Controllers/PostController.php
```
 /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'body' => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ], 422);
        }

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post Not Found!'
            ], 404);
        }

        $post->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully!',
            'data' => new PostResource($post)
        ], 200);
    }
```
# STEP 17 Add new route PUT 127.0.0.1:8000/api/posts/1

# STEP 18 Delete  app/Http/Controllers/PostController.php
```
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post Not Found!'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully!',            
        ]);
    }
```
# STEP 19 Add route DELETE 127.0.0.1:8000/api/posts/2

# STEP 20 Show all posts app/Http/Controllers/PostController.php
```
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'status'  => true,
            'message' => 'Posts retrieved successfully!',
            'data'    => PostResource::collection($posts)
        ], 200);
    }



```


# STEP 21 Add route GET 127.0.0.1:8000/api/posts

# STEP 22 Add route GET http://127.0.0.1:8000/api/posts?page=2
* Comment this code
```
        // $posts = Post::all();
        // return response()->json([
        //     'status'  => true,
        //     'message' => 'Posts retrieved successfully!',
        //     'data'    => PostResource::collection($posts)
        // ], 200);
```

* Past this code
```
$posts = Post::paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Posts retrieved successfully!',
            'data' => [
                'posts' => PostResource::collection($posts),
                'pagination' => [
                    'total' => $posts->total(),
                    'per_page' => $posts->perPage(),
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                    'next_page_url' => $posts->nextPageUrl(),
                    'prev_page_url' => $posts->previousPageUrl(),
                ]
            ]
        ],200);
```