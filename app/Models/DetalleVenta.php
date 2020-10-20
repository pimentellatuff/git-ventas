<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='detalle_ventas';

    protected $primaryKey='iddetalle_ventas';

    public $timestamps=false;

    protected $fillable=[

        'idventas',
        'idarticulos',
        'cantidad',
        'precio_venta',
        'descuento',
    ];
    protected $guarded=[

    ];
}