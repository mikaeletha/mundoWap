<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';
    protected $fillable = ['name'];
    public $timestamps = false;

    public function addresses()
    {
        return $this->hasMany(Address::class, 'foreign_id')->where('foreign_table', 'stores');
    }
}
