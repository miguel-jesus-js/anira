<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_table_id', 'type_table_id', 'name', 'description', 'capacity', 'status'];

    const filters = [
        'type_table_id' => '',

    ];

    const columnsExport = [
        'type_table_id' => 'Tipo de tabla',
    ];
}
