<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table='profiles';
    public $fillable=[
        'first_name',
        'last_name'
    ];
    public $timestamps=true;
}
