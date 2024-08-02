<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gk_gates extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'status',
        'lokasi',
        'detail',
        'foto',
        'id_destinasi',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function destinasi() {
        return $this->belongsTo(destinasi::class, 'id_destinasi');
    }

    public function gambar_gates() {
        return $this->hasMany(gambar_gates::class, 'id_gate');
    }
}
