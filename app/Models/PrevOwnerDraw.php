<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrevOwnerDraw extends Model
{
    use HasFactory;

    protected $table = 'prevownerdraws'; // Explicitly set the table name

    protected $fillable = [
        'stubno',
        'prevpayday',
        'ownerdrawamount'
    ];

    public function paystub()
    {
        return $this->belongsTo(Paystub::class, 'stubno', 'stubno'); // Specify custom foreign key and local key
    }
}