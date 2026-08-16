<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 1:1 - Um usuário tem um perfil
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * 1:N - Um usuário tem vários posts
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
