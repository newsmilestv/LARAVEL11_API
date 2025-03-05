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

# STEP 12