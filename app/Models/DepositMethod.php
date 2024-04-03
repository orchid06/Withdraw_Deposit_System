<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    use HasFactory;

    protected $table    = 'deposit_methods'; 
    protected $fillable = ['name', 'is_active', 'fields', 'min' , 'max'];
    protected $cast     = ['is_active' => 'boolean'];

    public function deposit_request()
    {
        return $this->hasMany(DepositRequest::class);
    }
}
