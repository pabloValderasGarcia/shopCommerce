<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $fillable = [
        'name', 'excerpt', 'description', 'image',
        'price', 'stock', 'year', 'idBrand', 'idColor', 'idCat',
    ];
    
    public function brand() {
        return $this->belongsTo('App\Models\Brand', 'id');
    }
    
    public function color() {
        return $this->belongsTo('App\Models\Color', 'id');
    }
    
    public function category() {
        return $this->belongsTo('App\Models\Category', 'id');
    }
    
    function storeProduct() {
        try {
            $this->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function updateProduct($productData) {
        try {
            $this->update($productData);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    function deleteProduct() {
        try {
            $this->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
