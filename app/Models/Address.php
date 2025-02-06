<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['address', 'street', 'neighborhood', 'interior_number', 'outer_number',  'city', 'state', 'locality', 'cp', 'latitude', 'longitude'];

    public function people()
    {
        return $this->belongsToMany(People::class, 'address_people');
    }
}
