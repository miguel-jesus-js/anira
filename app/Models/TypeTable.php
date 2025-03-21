<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TypeEmployee
 * @property int $id
 * @property int $status
 */
class TypeTable extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_table', 'status'];

    const filters = [
        'type_table' => '',
    ];

    const columnsExport = [
        'type_table' => 'Tipo de empleado',
    ];

    public function scopeTypeEmployee($query, $type)
    {
        return $query->where('type_table', 'LIKE', '%'. $type .'%');
    }
}
