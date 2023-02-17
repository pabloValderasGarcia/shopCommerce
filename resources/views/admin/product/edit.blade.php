@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}" class="active">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<div class="container" style="width: 70%; margin: 3em auto 3em auto">
    <div class="mb-30" style="font-size: 2em; font-weight: bold">Edit Product</div>
    <form action="{{ url('/shop/products/' . $product->id) }}" class="row g-3" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input minlength="3" maxlength="20" type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="number" min="1" step="any" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-12">
            <label for="excerpt" class="form-label">Excerpt</label>
            <input minlength="10" maxlength="100" type="text" class="form-control" name="excerpt" id="excerpt" value="{{ old('excerpt', $product->excerpt) }}" required>
            @error('excerpt')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea minlength="50" maxlength="600" type="text" class="form-control" name="description" id="description" style="min-height: 10em" required>{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-4">
            <label for="idColor" class="form-label">Color</label>
            <select style="cursor: pointer;" id="idColor" class="form-select" name="idColor" value="{{ old('idColor') }}" required>
                <option disabled>Choose...</option>
                @foreach($colors as $color)
                    @if($color->id == $product->idColor)
                        <option style="cursor: pointer; background-color: {{ $color->hex }}; color: transparent" selected>{{ ucfirst($color->name) }}</option>
                    @else
                        <option style="cursor: pointer; background-color: {{ $color->hex }}; color: transparent">{{ ucfirst($color->name) }}</option>
                    @endif
                @endforeach
            </select>
            @error('color')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        
        <div class="col-4">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" min="1" step="any" class="form-control" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required>
            @error('stock')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-4">
            <label for="year" class="form-label">Year</label>
            <input type="number" min=1990 max=2023 step="any" class="form-control" name="year" id="year" value="{{ old('year', $product->year) }}" required>
            @error('year')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="idBrand" class="form-label">Brand</label>
            <select style="cursor: pointer" id="idBrand" class="form-select" name="idBrand" value="{{ old('idBrand', $product->idBrand) }}" required>
                <option disabled>Choose...</option>
                @foreach($brands as $brand)
                    @if($brand->id == $product->idBrand)
                        <option selected>{{ $brand->name }}</option>
                    @else
                        <option>{{ $brand->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('brand')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-6">
            <label for="idCat" class="form-label">Category</label>
            <select style="cursor: pointer" id="idCat" class="form-select" name="idCat" value="{{ old('idCat', $product->idCat) }}" required>
                <option disabled>Choose...</option>
                @foreach($categories as $category)
                    @if($category->id == $product->idCat)
                        <option selected>{{ $category->name }}</option>
                    @else
                        <option>{{ $category->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('category')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="col-md-12 form-group">
	        <label class="form-label" for="thumbnail">Thumbnail</label>
	        <div class="upload__box">
                <div class="upload__btn-box" style="position: relative">
                    <label id="thumbnail_label" class="upload__btn" style="position: relative; z-index: 1">
                        <i class="fas fa-image" style="font-size: 3em; color: rgb(220, 220, 220)"></i>
                        <p class="mb-0">Choose thumbnail</p>
                    </label>
                    <input type="file" id="thumbnail_input" name="thumbnail" data-type="thumbnail" class="upload__thumbnail" value="{{ old('thumbnail', $product->thumbnail) }}" style="border: none; color: transparent; background-color: transparent; position: absolute; bottom: 0; left: 35%; z-index: 0">
                </div>
                <div id="thumbnail_wrap" class="upload__img-wrap w-100">
                    <div class="upload__img-box">
                        <div style="background-image: url(data:image/jpeg;base64,{{ $product->thumbnail }})" class="img-bg"><div class="upload__img-close"></div></div>
                    </div>
                </div>
            </div>
            @error('thumbnail')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
	        @enderror
	    </div>
	    
	    <div class="col-md-12 form-group mb-3">
	        <label class="form-label" for="image">Upload images</label>
	        <div class="upload__box">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <i class="fa-solid fa-folder-open" style="font-size: 3em; color: rgb(220, 220, 220)"></i>
                        <p class="mb-0">Choose images</p>
                        <input type="file" id="images_input" name="image[]" multiple="" data-type="images" class="upload__inputfile">
                    </label>
                </div>
                <div id="images_wrap" class="upload__img-wrap upload_images_wrap">
                    @foreach($images as $image)
                        <div class="upload__img-box">
                            <div style="background-image: url({{ asset('../storage/app/imagesProduct-' . $product->id . '/' . $image['path']) }})" data-url="{{ url('deleteImage/' . $image['id']) }}" class="img-bg">
                                <div class="upload__img-close deleteImageClass"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('image')
                <div class="alert alert-danger container pl-15">{{ $message }}</div>
	        @enderror
	    </div>
        
        <div class="col-12" style="display: flex; text-align: center; gap: 1em; margin-top: 1em">
            <a href="{{ url('/dashboard') }}" class="element-management element-management2 create_product" style="flex: .2">Back</a>
            <button type="submit" class="element-management create_product" style="border: none; flex: .8">Edit Product</button>
        </div>
    </form>
</div>

<form action="" method="POST" id="deleteImageForm">
    @csrf
    @method('delete')
</form>

@endsection