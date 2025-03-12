<?php

namespace App\Traits;

use App\Models\People;

trait HasPeopleScopes
{
    public function scopeFirstName($query, $firstName)
    {
        return $query->whereHas('people', function ($q) use ($firstName) {
            $q->where('first_name', 'like', '%' . $firstName . '%');
        });
    }

    public function scopeLastName($query, $lastName)
    {
        return $query->whereHas('people', function ($q) use ($lastName) {
            $q->where('last_name', 'like', '%' . $lastName . '%');
        });
    }

    public function scopeEmail($query, $email)
    {
        return $query->whereHas('people', function ($q) use ($email) {
            $q->where('email', 'like', '%' . $email . '%');
        });
    }

    public function scopeDni($query, $dni)
    {
        return $query->whereHas('people', function ($q) use ($dni) {
            $q->where('dni', 'like', '%' . $dni . '%');
        });
    }

    public function scopePhone($query, $phoneNumber)
    {
        return $query->whereHas('people', function ($q) use ($phoneNumber) {
            $q->where('phone_number', 'like', '%' . $phoneNumber . '%');
        });
    }

    public function people()
    {
        return $this->belongsTo(People::class);
    }
}
