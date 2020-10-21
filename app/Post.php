<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Favorable;
    protected $appends = ['favoriteCount', 'isFavorited', 'commentCount'];
    protected $casts = ['isFavorited' => 'boolean'];
    protected $with = ['user:id,name,image', 'category:id,name'];
    protected $guarded = [];

    public function comments() {
        return $this->hasMany(Comment::class)->latest();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getCommentCountAttribute() {
        return $this->comments()->count();
    }

    public function getCreatedAtAttribute($value) {
        return (new Carbon($value))->diffForHumans();
    }
}
