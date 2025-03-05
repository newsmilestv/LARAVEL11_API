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

# STEP 8 
