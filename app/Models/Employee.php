<?php

namespace App\Models;

use App\Traits\HasPeopleScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasPeopleScopes;
    protected $fillable = ['people_id', 'type_employee_id', 'status'];

    const filters = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'dni' => '',
        'phone_number' => '',
        'user_name' => '',
        'type' => '',
    ];

    const columnsExport = [
        'id' => 'ID',
        'first_name' => 'Nombre(s)',
        'last_name' => 'Apellido(s)',
        'email' => 'Correo',
        'dni' => 'DNI',
        'phone_number' => 'Telefono',
        'user_name' => 'Nombre de usuario',
        'type' => 'Tipo de empleado',
        'status' => 'Estado',
    ];

    const STATUS = [
        'Inactivo',
        'Activo',
    ];

    public function getStatusTextAttribute(): string
    {
        return match ($this->attributes['status'])
        {
            0 => 'Inactivo',
            1 => 'Activo',
        };
    }
    public function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeType($query, $type)
    {
        return  $query->where('type_employee_id', $type);
    }
    public function scopeStatus($query, $status)
    {
        return  $query->where('status', $status);
    }
    public function people(): BelongsTo
    {
        return $this->belongsTo(People::class);
    }
    public function typeEmployee(): BelongsTo
    {
        return $this->belongsTo(TypeEmployee::class);
    }
}
