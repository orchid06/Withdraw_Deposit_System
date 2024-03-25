<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw_Method extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parameter', 'min', 'max'];

    public function withdraw_request()
    {
        return $this->hasMany(Withdraw_Request::class);
    }
}
