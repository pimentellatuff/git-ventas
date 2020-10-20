<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='ventas';

    protected $primaryKey='idventas';

    public $timestamps=false;

    protected $fillable=[

        'idclientes',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total_ventas',
        'estado',
    ];
    protected $guarded=[

    ];
}