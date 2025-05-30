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
class TypeEmployee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['type_employee', 'status'];

    const filters = [
        'type_employee' => '',
    ];

    const columnsExport = [
        'type_employee' => 'Tipo de empleado',
    ];

    public function scopeTypeEmployee($query, $type)
    {
        return $query->where('type_employee', 'LIKE', '%'. $type .'%');
    }
}
