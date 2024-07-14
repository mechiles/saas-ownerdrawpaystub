<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Paystub extends Model
{
    use HasFactory;

    protected $table = 'paystubs'; // Explicitly set the table name

    protected $fillable = [
        'companyname',
        'einno',
        'companyphone',
        'companystreet',
        'companycity',
        'companystate',
        'companyzip',
        'companycountry',
        'firstname',
        'middlename',
        'lastname',
        'street',
        'city',
        'state',
        'zip',
        'country',
        'ssn',
        'title',
        'employeeid',
        'email',
        'paystartday',
        'payendday',
        'payday',
        'grossincome',
        'stubno',
        'user_id',
        'netpayamount'
    ];

    public function prevOwnerDraws()
    {
        return $this->hasMany(PrevOwnerDraw::class, 'stubno', 'stubno')->where('user_id', Auth::id());
    }
    
}
