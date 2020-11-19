<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'contacto',
        'telefono_contacto',
    ];
  //un proveedor pertenece a una persona
    public function persona(){
        return $this->belongsTo(Persona::class,'id');

    }
}
