<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
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
    public function scopeFirstName($query, $firstName)
    {
        return $query->whereHas('people', function ($q) use ($firstName){
         $q->where('first_name', 'like', '%' . $firstName . '%');
        });
    }
    public function scopeLastName($query, $lastName)
    {
        return $query->whereHas('people', function ($q) use ($lastName){
            $q->where('last_name', 'like', '%' . $lastName . '%');
        });
    }
    public function scopeEmail($query, $email)
    {
        return $query->whereHas('people', function ($q) use ($email){
            $q->where('email', 'like', '%' . $email . '%');
        });
    }
    public function scopeDni($query, $dni)
    {
        return $query->whereHas('people', function ($q) use ($dni){
            $q->where('dni', 'like', '%' . $dni . '%');
        });
    }
    public function scopePhone($query, $phoneNumber)
    {
        return $query->whereHas('people', function ($q) use ($phoneNumber){
            $q->where('phone_number', 'like', '%' . $phoneNumber . '%');
        });
    }
    public function scopeUserName($query, $userName)
    {
        return $query->whereHas('user', function ($query) use ($userName) {
            $query->where('user_name', 'LIKE', "%$userName%");
        });
    }
    public function scopeType($query, $type)
    {
        return  $query->where('type_employee_id', $type);
    }
    public function people()
    {
        return $this->belongsTo(People::class);
    }
    public function typeEmployee()
    {
        return $this->belongsTo(TypeEmployee::class);
    }
}
