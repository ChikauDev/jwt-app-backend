<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function likes(){
        return $this->morphMany(Like::class, 'likeable');
    }
}
