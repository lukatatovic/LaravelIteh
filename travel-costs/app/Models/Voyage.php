<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination',
        'arrival',
        'departure',
        'transportation',
        'total_cost'
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
