<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Image;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller {
    public function __construct() {
        $this->middleware(['auth', 'admin'])->except(['index', 'show']);
    }
    
    public function index() {
        return view('product.index', ['product' =>  $product]);
    }
    
    public function create() {
        $brands = Brand::all();
        $colors = Color::all();
        $categories = Category::all();
        return view('admin.product.create', [
            'brands' => $brands,
            'colors' => $colors,
            'categories' => $categories
        ]);
    }
    
    public function removeImagesProduct($product) {
        DB::table('image')->where('idProduct', $product->id)->delete();
    }
    
    public function createImagesProduct($request, $product) {
        foreach($request->image as $otherImage) {
            if ($otherImage->isValid()) {
                $uniqueName = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 10);
                $name = $uniqueName . '-' . $product->id . '.' . $otherImage->extension();
                $path = 'imagesProduct-' . $product->id;
                
                $namePath = Storage::disk('local')
                    ->putFileAs($path, $otherImage, $name);
                    
                $imageModel = new Image();
                $imageModel->path = $name;
                $imageModel->idProduct = $product->id;
                
                try {
                    $imageModel->save();
                } catch (\Exception $e) {}
            }
        }
    }
    
    public function createThumbnail($request, $product) {
        $image = $request->file('thumbnail');
        $path = $image->getRealPath();
        $image = file_get_contents($path);
        $product->thumbnail = base64_encode($image);
    }
    
    public function store(Request $request) {
        try {
            $request->merge(['idBrand' => Brand::where('name', $request->idBrand)->first()->id]);
            $request->merge(['idColor' => Color::where('name', $request->idColor)->first()->id]);
            $request->merge(['idCat' => Category::where('name', $request->idCat)->first()->id]);
            
            $productData = $request->validate([
                'name' => 'required|string|min:3|max:20',
                'excerpt' => 'required|string|min:10|max:100',
                'description' => 'required|string|min:50|max:600',
                'price' => 'required|string|min:1',
                'stock' => 'required|integer',
                'year' => 'required|integer',
                'idBrand' => 'required|integer',
                'idColor' => 'required|integer',
                'idCat' => 'required|integer'
            ]);
            
            $productData['name'] = ucfirst($productData['name']);
            $product = new Product($productData);
            
            // Images
            if ($request->hasFile('thumbnail')) {
                $this->createThumbnail($request, $product);
                
                if ($product->storeProduct()) {
                    if ($request->hasFile('image')) {
                        $this->createImagesProduct($request, $product);
                    }
                    
                    $message = 'Product has been created.';
                    return redirect('/dashboard')->with('message', $message);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors(['message' => 'An unexpected error occurred while creating product.']);
                }
            } else {
                return back()
                    ->withInput()
                    ->withErrors(['message' => 'Thumbnail weight more than expected']);
            }
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['message' => 'Could not store product name...']);
        }
    }

    public function show(Product $product) {
        $images = Image::where('idProduct', $product->id)->get()->toArray();
        $relatedProducts = DB::table('products')->where('price', '=', $product->price)
                                                ->orWhere('stock', '=', $product->price)
                                                ->orWhere('year', '=', $product->year)
                                                ->orWhere('idBrand', '=', $product->idBrand)
                                                ->orWhere('idColor', '=', $product->idColor)
                                                ->orWhere('idCat', '=', $product->idCat)->get()->toArray();
        return view('product.show', [
            'images' =>  $images,
            'product' =>  $product,
            'relatedProducts' =>  $relatedProducts
        ]);
    }

    public function edit(Product $product) {
        $images = Image::where('idProduct', $product->id)->get()->toArray();
        $brands = Brand::all();
        $colors = Color::all();
        $categories = Category::all();
        return view('admin.product.edit', [
            'product' => $product, 
            'images' => $images,
            'brands' => $brands,
            'colors' => $colors,
            'categories' => $categories
        ]);
    }
    
    public function update(Request $request, Product $product) {
        $request->merge(['idBrand' => Brand::where('name', $request->idBrand)->first()->id]);
        $request->merge(['idColor' => Color::where('name', $request->idColor)->first()->id]);
        $request->merge(['idCat' => Category::where('name', $request->idCat)->first()->id]);
        $productData = $request->validate([
            'name' => 'required|string|min:3|max:20',
            'excerpt' => 'required|string|min:10|max:100',
            'description' => 'required|string|min:50|max:600',
            'price' => 'required|string|min:1',
            'stock' => 'required|integer',
            'year' => 'required|integer',
            'idBrand' => 'required|integer',
            'idColor' => 'required|integer',
            'idCat' => 'required|integer'
        ]);
        
        if ($request->hasFile('thumbnail')) {
            $this->createThumbnail($request, $product);
        }
        
        if ($product->updateProduct($productData)) {
            if ($request->hasFile('image')) {
                $this->removeImagesProduct($product);
                $this->createImagesProduct($request, $product);
            }
            
            $message = "Product with id $product->id has been updated.";
            return back()->with('message', $message);
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while updating product.']);
        }
    }
    
    public function destroy(Product $product) {
        $name = $product->name;
        $message = 'Product ' . $name . ' has not been removed.';

        if($product->deleteProduct()){
           $message = 'Product ' . $name . ' has been removed.';
           return back()->with('message', $message);
        }
    }
    
    public function deleteImage(Image $image) {
        Storage::delete($image->path);
        try {
            $image->delete();
            return back()->with('message', 'Image delete successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Could not delete image']);
        }
    }
}
