<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable     = [
        'cidade',
        'uf',
        'cep',
        'bairro',
        'localizacao',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];
}
