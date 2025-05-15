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
        'address_id' => 'Dirección',
        'name' => 'Nombre',
        'email' => 'Correo',
        'phone_number' => 'Telefono',
        'status' => 'Estado',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
