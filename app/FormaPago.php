<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'formapago';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'nombre',
        'condicion',
    ];

}
