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
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isOrganizador(): bool
    {
        return $this->role === 'organizador';
    }

    public function isParticipante(): bool
    {
        return $this->role === 'participante';
    }

    /**
     * Eventos criados por este usuário (quando organizador)
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Eventos em que este usuário está inscrito (quando participante)
     */
    public function inscricoes()
    {
        return $this->belongsToMany(Event::class, 'event_user')
                     ->withPivot('ticket_code', 'status')
                     ->withTimestamps();
    }
}