<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OportunidadAdicional extends Model
{
    protected $table = 'oportunidades_adicionales';
    
    protected $fillable = [
        'user_id', 'pregunta_id', 'otorgada_por', 'otorgada_at',
        'consumida', 'consumida_at'
    ];

    protected $casts = [
        'otorgada_at' => 'datetime',
        'consumida' => 'boolean',
        'consumida_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function otorgadaPor()
    {
        return $this->belongsTo(User::class, 'otorgada_por');
    }
    
    public function scopeNoConsumida($query)
    {
        return $query->where('consumida', false);
    }
}
