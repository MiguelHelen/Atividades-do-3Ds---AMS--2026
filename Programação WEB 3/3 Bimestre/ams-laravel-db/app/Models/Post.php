<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * N:1 - Post pertence a um usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * N:M - Um post pode ter várias tags (via tabela pivô post_tag)
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
