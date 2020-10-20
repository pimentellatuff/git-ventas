<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Articulo extends Model
{
    protected $table='articulos';

    protected $primaryKey='idarticulos';

    public $timestamps=false;

    protected $fillable=[

        'idcategorias',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado'
    ];
    protected $guarded=[

    ];
}
