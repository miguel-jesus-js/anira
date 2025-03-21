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
        'type_customer' => '',
    ];

    const columnsExport = [
        'type_customer' => 'Tipo de cliente',
    ];


    public function scopeTypeCustomer($query, $type)
    {
        return $query->where('type_customer', 'LIKE', '%'. $type .'%');
    }
}
