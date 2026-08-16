<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'phone',
    ];

    /**
     * 1:1 - Perfil pertence a um usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
