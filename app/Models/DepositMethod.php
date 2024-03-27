<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parameter', 'min' , 'max'];

    public function deposit_request()
    {
        return $this->hasMany(DepositRequest::class);
    }
}
