<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'company', 'email', 'phone_numbers', 'dietary_preferences'];

    public function getPhoneNumbersAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setPhoneNumbersAttribute($value)
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        $this->attributes['phone_numbers'] = json_encode($value);
    }
    
}
