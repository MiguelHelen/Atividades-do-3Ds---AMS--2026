<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'date_time',
        'location',
        'capacity',
        'banner_path',
    ];

    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
        ];
    }

    /**
     * Organizador responsável pelo evento
     */
    public function organizador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Participantes inscritos neste evento
     */
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'event_user')
                     ->withPivot('ticket_code', 'status')
                     ->withTimestamps();
    }

    /**
     * RN05 - Verifica se o evento está com vagas esgotadas
     */
    public function isLotado(): bool
    {
        return $this->participantes()->count() >= $this->capacity;
    }

    /**
     * Quantidade de vagas disponíveis
     */
    public function vagasDisponiveis(): int
    {
        return max(0, $this->capacity - $this->participantes()->count());
    }

    /**
     * Caminho público do banner 
     */
    public function bannerUrl(): string
    {
        return $this->banner_path
            ? asset('storage/' . $this->banner_path)
            : 'https://placehold.co/800x450/6366f1/white?text=Passaporte.io';
    }

    /**
 * Verifica se o evento foi criado há menos de 3 horas 
 */
public function isNovo(): bool
{
    return $this->created_at->greaterThan(now()->subHours(3));
}
}