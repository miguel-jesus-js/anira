<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['people_id', 'type_employee_id', 'status'];

    public function people()
    {
        return $this->belongsTo(People::class);
    }
    public function typeEmployee()
    {
        return $this->belongsTo(TypeEmployee::class);
    }
}
