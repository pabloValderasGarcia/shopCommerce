<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $table = 'carts';
    protected $fillable = ['quantity', 'idUser', 'idProduct'];
    
    public function user() {
        return $this->belongsTo('App\Models\User', 'idUser');
    }
    
    public function product() {
        return $this->belongsTo('App\Models\Product', 'idProduct');
    }
    
    function deleteCart() {
        try {
            $this->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
