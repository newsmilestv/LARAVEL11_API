<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //protected string $table = 'posts';

    protected $fillable = ['title', 'body'];
}
