<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $table='routes';
    public $fillable=[
        'route_name',
        'route_no'
    ];
    public $timestamps=true;


    public function salessummary()
    {
        return $this->hasMany(Transaction::class);
    }

}
