<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $table = 'image';
    protected $fillable = ['name', 'idProduct'];
    
    public function review() {
        return $this->belongsTo('App\Models\Product', 'idProduct');
    }
}
