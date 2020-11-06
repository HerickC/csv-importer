<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [
        'name',
        'email',
        'doc',
        'birthday',
        'raw_address',
    ];
    use HasFactory;

    public function addresses()
    {
        return $this->hasMany('App\Models\Addresses', 'client_id');
    }
}
