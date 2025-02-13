<?php

namespace App\Models;

use App\Enums\StatusBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeEmployee
 * @property int $id
 * @property int $status
 */
class TypeEmployee extends Model
{
    use HasFactory;
    protected $fillable = ['type_employee', 'status'];
    protected $casts = [
        'status' => StatusBase::class
    ];
    public function getStatusLabelAttribute()
    {
        return StatusBase::from($this->attributes['status'])->label();
    }
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
