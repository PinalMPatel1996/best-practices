<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'file_path', 'visibility', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Note: we can use this scope when we need to get only logged-in user's post */
    public function scopeMyPosts(Builder $query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeFilterByUserId(Builder $query, $userId)
    {
        if ($userId) {
            $query->where('user_id', $userId);
        }

        return $query;
    }

    public function getFileUrlAttribute()
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function saveFile($file)
    {
        $fileExists = $this->where('file_path', $this->file_path)->exists();

        if ($file && !is_null($this->file_path) && $fileExists) {
            Storage::delete($this->file_path);
        }

        $this->file_path = Storage::put('posts',$file);
        $this->save();
    }

    public static function visibilities()
    {
        return [
            self::VISIBILITY_PUBLIC,
            self::VISIBILITY_PRIVATE,
        ];
    }
}
