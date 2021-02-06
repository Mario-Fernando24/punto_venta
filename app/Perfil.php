<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    
    protected $table = 'perfil';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_admin',
        'nit',
        'impuesto',
        'razon_social',
        'codigo_postal',
        'propietario',
        'ciudad',
        'telefono',
        'direccion',
        'correo',
        'image_perfil',
    ];

    public function GetUser(){
        return $this->belongsTo(User::class,'id_admin','id');
    }
}
