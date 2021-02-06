<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    
    protected $table = 'persona';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name_empresa',
        'propietario',
        'departamento',
        'municipio',
        'telefono',
        'correo',
        'image_perfil',

    ];


}
