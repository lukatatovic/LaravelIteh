<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'cost',
        'date',
        'friend_id',
        'voyage_id'
    ];

    public function friend()
    {
        return $this->belongsTo(Friend::class);
    }

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public static function getAllExpenses()
    {
        $result = DB::table('expenses')
            ->select('voyage_id', 'friend_id', 'description', 'cost')
            ->get()->toArray();
        return $result;
    }
}
