<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'registration_number', 'is_registered'];

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public static function rules()
    {
        return [
            'name' => 'required',
            'registration_number' => 'nullable|unique:cars',
            'is_registered' => 'required',
        ];
    }
}
