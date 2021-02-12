<?php

namespace App\ModelInventario;

use Illuminate\Database\Eloquent\Model;
use App\User;

class AjusteInventario extends Model
{

    protected $table = 'ajusteinventario';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_usuario',
        'id_anulo_ajuste',
        'id_apertura_caja_usuario',
        'tipo_ajuste',
        'motivo',
        'impuesto',
        'total',
        'estado',
    ];


    public function usuario_hizo_el_ajuste(){
        return $this->belongsTo(User::class,'id_usuario');
    }

    public function usuario_anulo_el_ajuste(){
        return $this->belongsTo(User::class,'id_anulo_venta');
    }

}
