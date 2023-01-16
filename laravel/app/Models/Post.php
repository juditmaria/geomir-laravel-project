<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $fillable = [
        'body',
        'file_id',
        'latitude',
        'longitude',
        'visibility_id',
        'author_id'
    ];

    public function file()
    {
       return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function liked()
    {
        return $this->belongsToMany(User::class, 'likes');
    }
    
    public function likedByUser(User $user)
    {
        $count = Like::where([
            ['user_id',  '=', auth()->user()->id],
            ['post_id', '=', $this->id],
        ])->count();
        
        return $count > 0;
    }

    public function likedByAuthUser()
    {
        $user = auth()->user();
        return $this->likedByUser($user);
    }

    public function visibility()
    {
       return $this->belongsTo(Visibility::class);
    }
}
