<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['address_id', 'employee_id', 'name', 'email', 'country_code', 'phone_number', 'status'];

    const columnsExport = [
        'id' => 'ID',
        'address_id' => 'Dirección',
        'name' => 'Nombre',
        'email' => 'Correo',
        'phone_number' => 'Teléfono',
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
    public  function scopeId($query, $id)
    {
        return $query->where('id', $id);
    }
    public function scopeAddressByAddress($query, $address)
    {
        return $query->whereHas('address', function ($query) use ($address) {
            $query->where('address', 'LIKE', "%$address%");
        });
    }
    public function scopeMandated($query, $name)
    {
        return $query->whereHas('employee.people', function ($query) use ($name) {
            $query->where('first_name', 'LIKE', "%$name%")->orWhere('last_name', 'LIKE', "%$name%");
        });
    }
    public function scopeEmail($query, $email)
    {
        return $query->where('email', $email);
    }
    public function scopePhone($query, $phone)
    {
        return $query->where('phone_number', $phone);
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
