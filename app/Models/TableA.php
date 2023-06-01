<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableA extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name', 'user_star'];

    public function tableB()
    {
        return $this->hasOne(TableB::class);
    }    

}
