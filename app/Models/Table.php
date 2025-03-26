<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_table_id', 'number', 'name', 'description', 'capacity', 'status'];

    const columnsExport = [
        'type_table_id' => 'Tipo de mesa',
        'number' => 'Numero',
        'name' => 'Nombre',
        'description' => 'Descripción',
        'capacity' => 'Capacidad',
        'status' => 'Estado',
    ];

    public function typeTable(): BelongsTo
    {
        return $this->belongsTo(TypeTable::class);
    }

    public function scopeTypeTable($query, $typeTableId)
    {
        return $query->where('type_table_id', $typeTableId);
    }
    public function scopeNumber($query, $number)
    {
        return $query->where('number', $number);
    }
    public function scopeName($query, $name)
    {
        return $query->where('name', 'LIKE', "%$name%");
    }
    public function scopeDescription($query, $description)
    {
        return $query->where('description', 'LIKE', "%$description%");
    }
    public function scopeCapacity($query, $capacity)
    {
        return $query->where('capacity', $capacity);
    }
}
