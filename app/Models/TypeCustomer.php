<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeCustomers
 * @property int $id
 * @property string $type_customer
 * @property int $status
 */
class TypeCustomer extends Model
{
    use HasFactory;
    protected $fillable = ['type_customer', 'status'];

    const filters = [
        'id' => '',
        'type_customer' => '',
        'status' => ''
    ];

    const columnsExport = [
        'id' => 'ID',
        'type_customer' => 'Tipo de cliente',
        'status' => 'Estado'
    ];


    public function scopeId($query, $id)
    {
        return $query->where('id', 'LIKE', $id);
    }
    public function scopeTypeCustomer($query, $type)
    {
        return $query->where('type_customer', 'LIKE', '%'. $type .'%');
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
