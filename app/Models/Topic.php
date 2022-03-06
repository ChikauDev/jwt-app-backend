<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Orderable;

class Topic extends Model
{
    use HasFactory;
    use Orderable;

    protected $fillable = ['title'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
}
