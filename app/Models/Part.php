<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'serialnumber', 'car_id'];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public static function rules()
    {
        return [
            'name' => 'required|string',
            'serialnumber' => 'required|string|unique:parts',
        ];
    }
}
