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
        'id' => '',
        'type_employee' => '',
        'status' => '',
    ];

    const columnsExport = [
        'id' => 'ID',
        'type_employee' => 'Tipo de empleado',
        'status' => 'Estado',
    ];

    public function getStatusTextAttribute(): string
    {
        return match ($this->attributes['status'])
        {
            0 => 'INACTIVO',
            1 => 'ACTIVO',
        };
    }

    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeTypeEmployee($query, $type)
    {
        return $query->where('type_employee', 'LIKE', '%'. $type .'%');
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('id', $status);
    }
}
