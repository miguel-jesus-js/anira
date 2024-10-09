<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'first_name', 'last_name', 'email', 'contry_code', 'phone_number'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
