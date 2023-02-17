<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    const ORDER_BY = 'products.name';
    const ORDER_TYPE = 'asc';
    const ITEMS_PER_PAGE = 3;
    
    private function getOrder($orderArray, $order, $default) {
        $value = array_search($order, $orderArray);
        if(!$value) {
            return $default;
        }
        return $value;
    }

    private function getOrderBy($order) {
        return $this->getOrder($this->getOrderBys(), $order, self::ORDER_BY);
    }
    
    private function getOrderBys() {
        return [
            'products.name' => 'b1',
            'products.price' => 'b2'
        ];
    }

    private function getOrderType($order) {
        return $this->getOrder($this->getOrderTypes(), $order, self::ORDER_TYPE);
    }

    private function getOrderTypes() {
        return [
            'asc'  => 't1',
            'desc' => 't2'
        ];
    }
    
    private function getOrderUrls($oBy, $oType, $q) {
        $urls = [];
        $orderBys = $this->getOrderBys();
        $orderTypes = $this->getOrderTypes();
        foreach($orderBys as $indexBy => $by) {
            foreach($orderTypes as $indexType => $type) {
                if($oBy == $indexBy && $oType == $indexType) {
                    $urls[$indexBy][$indexType] = url()->full() . '#';
                } else {
                    $urls[$indexBy][$indexType] = route('shop.index', [
                                                        'orderby' => $by,
                                                        'ordertype' => $type,
                                                        'q' => $q]);
                }
            }
        }
        return $urls;
    }
    
    public function index(Request $request) {
        $products = Product::all();
        $categories = Category::all();
        
        // Filters
        $colors = Color::all();
        $brands = Brand::all();
        $stocks = DB::table('products')->select('stock')->distinct()->get();
        $years = DB::table('products')->select('year')->distinct()->get();
        
        // ------- Use filters -------
        $products = DB::table('products')
                        ->join('brands', 'brands.id', '=', 'products.idBrand')
                        ->join('colors', 'colors.id', '=', 'products.idColor')
                        ->leftJoin('categories', 'categories.id', '=', 'products.idCat')
                        ->select(
                            'products.*', 
                            'brands.name as brandName',
                            'colors.name as colorName',
                            'categories.name as catName'
                        );
                        
        // Orders
        $orderby = $this->getOrderBy($request->input('orderby'));
        $ordertype = $this->getOrderType($request->input('ordertype'));
        $products = $products->orderBy($orderby, $ordertype);
        if($orderby != self::ORDER_BY) {
            $products = $products->orderBy('products.name', 'asc');
        }
               
        // Search         
        $q = $request->input('q');
        if($q != ''){
            $products = $products->where('products.name', 'like', '%' . $q . '%')
                                 ->orWhere('products.excerpt', 'like', '%' . $q . '%')
                                 ->orWhere('products.description', 'like', '%' . $q . '%')
                                 ->orWhere('products.price', 'like', '%' . $q . '%')
                                 ->orWhere('products.stock', 'like', '%' . $q . '%')
                                 ->orWhere('products.year', 'like', '%' . $q . '%')
                                 ->orWhere('brands.name', 'like', '%' . $q . '%')
                                 ->orWhere('colors.name', 'like', '%' . $q . '%')
                                 ->orWhere('categories.name', 'like', '%' . $q . '%');
        }

        // ---- Checkboxs ----
        $checkboxs = $request->query();
        $categoriesBoxs = []; $brandsBoxs = []; $colorsBoxs = []; $stocksBoxs = []; $yearsBoxs = [];
        foreach(array_keys($checkboxs) as $checkbox) {
            $key = explode('-', $checkbox)[0];
            if (str_contains($checkbox, '-')) {
                $value = explode('-', $checkbox)[1];
                if ($key == 'category') array_push($categoriesBoxs, $value);
                if ($key == 'brand') array_push($brandsBoxs, $value);
                if ($key == 'color') array_push($colorsBoxs, $value);
                if ($key == 'stock') array_push($stocksBoxs, $value);
                if ($key == 'year') array_push($yearsBoxs, $value);
            }
        }
        
        // Categories
        if (!empty($categoriesBoxs)) {
            $products->where(function ($query) use ($categoriesBoxs) {
                $query->where('idCat', '=', $categoriesBoxs[0]);
                foreach($categoriesBoxs as $key => $category) {
                    if ($key >= 1) {
                        $query->orWhere('idCat', '=', $category);
                    }
                }
            });
        }
        
        // Brands
        if (!empty($brandsBoxs)) {
            $products->where(function ($query) use ($brandsBoxs) {
                $query->where('idBrand', '=', $brandsBoxs[0]);
                foreach($brandsBoxs as $key => $brand) {
                    if ($key >= 1) {
                        $query->orWhere('idBrand', '=', $brand);
                    }
                }
            });
        }
        
        // Brands
        if (!empty($colorsBoxs)) {
            $products->where(function ($query) use ($colorsBoxs) {
                $query->where('idColor', '=', $colorsBoxs[0]);
                foreach($colorsBoxs as $key => $color) {
                    if ($key >= 1) {
                        $query->orWhere('idColor', '=', $color);
                    }
                }
            });
        }
        
        // Stocks
        if (!empty($stocksBoxs)) {
            $products->where(function ($query) use ($stocksBoxs) {
                $query->where('stock', '=', $stocksBoxs[0]);
                foreach($stocksBoxs as $key => $stock) {
                    if ($key >= 1) {
                        $query->orWhere('stock', '=', $stock);
                    }
                }
            });
        }
        
        // Years
        if (!empty($yearsBoxs)) {
            $products->where(function ($query) use ($yearsBoxs) {
                $query->where('year', '=', $yearsBoxs[0]);
                foreach($yearsBoxs as $key => $year) {
                    if ($key >= 1) {
                        $query->orWhere('year', '=', $year);
                    }
                }
            });
        }
        
        // ----
        
        // Price
        if (!empty($checkboxs) && !isset($checkboxs['page']) && isset($checkboxs['priceMin'])) {
            if ($checkboxs['priceMin'] == null) $checkboxs['priceMin'] = 0;
            else $checkboxs['priceMin'] = intval($checkboxs['priceMin']);
            
            if ($checkboxs['priceMax'] == null) $checkboxs['priceMax'] = 999999999;
            else $checkboxs['priceMax'] = intval($checkboxs['priceMax']);
            
            $products = $products->orWhere(function ($query) use ($checkboxs) {
                $query->Where('price', '>=', $checkboxs['priceMin']);
                $query->Where('price', '<=', $checkboxs['priceMax']);
            });
        }
        
        // Pagination
        $totalProducts = count($products->get());
        $products = $products->paginate(self::ITEMS_PER_PAGE)->withQueryString();
        
        // Output
        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            
            // Filters
            'colors' => $colors,
            'years' => $years,
            'brands' => $brands,
            'stocks' => $stocks,
            
            // Use filters
            'items_per_page' => self::ITEMS_PER_PAGE,
            'total_items' => $totalProducts,
            'order' => $this->getOrderUrls($orderby, $ordertype, $q),
            'orderby' => $orderby,
            'ordertype' => $ordertype
        ]);
    }
    
    public function show() {
        return abort(404);
    }
}
