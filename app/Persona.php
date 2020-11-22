<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'nombre',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email',
    ];

    //una persona esta relacionada de forma directa con un solo proveedor
    public function proveedor()
    {
        return $this->hasOne(Proveedor::class);
        
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','id');
        
    }
}
