<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingresos';

    protected $primaryKey='iddetalle_ingresos';

    public $timestamps=false;

    protected $fillable=[

        'idingresos',
        'idarticulos',
        'cantidad',
        'precio_compra',
        'precio_venta',
    ];
    protected $guarded=[

    ];
}


					