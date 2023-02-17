@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}" class="active">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<div class="container" style="width: 70%; margin: 3em auto 3em auto">
    <div class="mb-30" style="font-size: 2em; font-weight: bold">Create Product</div>
    <form action="{{ url('/shop/products') }}" class="row g-3" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label for="name" class="form-label">Name</label>
            <input minlength="3" maxlength="20" type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>
        @error('name')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="number" min="1" step="any" class="form-control" name="price" id="price" value="{{ old('price') }}" required>
        </div>
        @error('price')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-md-12">
            <label for="excerpt" class="form-label">Excerpt</label>
            <input minlength="10" maxlength="100" type="text" class="form-control" name="excerpt" id="excerpt" value="{{ old('excerpt') }}" required>
        </div>
        @error('excerpt')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea minlength="50" maxlength="600" type="text" class="form-control" name="description" id="description" style="min-height: 10em" required>{{ old('description') }}</textarea>
        </div>
        @error('description')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        <div class="col-4">
            <label for="idColor" class="form-label">Color</label>
            <select style="cursor: pointer;" id="idColor" class="form-select" name="idColor" value="{{ old('idColor') }}" required>
                <option disabled selected>Choose...</option>
                @foreach($colors as $color)
                    <option style="cursor: pointer; background-color: {{ $color->hex }}; color: transparent">{{ ucfirst($color->name) }}</option>
                @endforeach
            </select>
        </div>
        @error('color')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-4">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" min="1" step="any" class="form-control" name="stock" id="stock" value="{{ old('stock') }}" required>
        </div>
        @error('stock')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-4">
            <label for="year" class="form-label">Year</label>
            <input type="number" min=1990 max=2023 step="any" class="form-control" name="year" id="year" value="{{ old('year') }}" required>
        </div>
        @error('year')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-md-6">
            <label for="idBrand" class="form-label">Brand</label>
            <select style="cursor: pointer" id="idBrand" class="form-select" name="idBrand" value="{{ old('idBrand') }}" required>
                <option disabled selected>Choose...</option>
                @foreach($brands as $brand)
                    <option>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        @error('brand')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-md-6">
            <label for="idCat" class="form-label">Category</label>
            <select style="cursor: pointer" id="idCat" class="form-select" name="idCat" value="{{ old('idCat') }}" required>
                <option disabled selected>Choose...</option>
                @foreach($categories as $category)
                    <option>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        @error('category')
            <div class="alert alert-danger container">{{ $message }}</div>
        @enderror
        
        <div class="col-md-12 form-group">
	        <label class="form-label" for="thumbnail">Thumbnail</label>
	        <div class="upload__box">
                <div class="upload__btn-box" style="position: relative">
                    <label id="thumbnail_label" class="upload__btn" style="position: relative; z-index: 1">
                        <i class="fas fa-image" style="font-size: 3em; color: rgb(220, 220, 220)"></i>
                        <p class="mb-0">Choose thumbnail</p>
                    </label>
                    <input type="file" id="thumbnail_input" name="thumbnail" data-type="thumbnail" class="upload__thumbnail" required style="color: transparent; background-color: transparent; position: absolute; bottom: 0; left: 35%; z-index: 0">
                </div>
                <div id="thumbnail_wrap" class="upload__img-wrap w-100"></div>
            </div>
            @error('thumbnail')
                <div class="alert alert-danger container">{{ $message }}</div>
	        @enderror
	    </div>
	    
	    <div class="col-md-12 form-group mb-3">
	        <label class="form-label" for="image">Upload images</label>
	        <div class="upload__box">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <i class="fa-solid fa-folder-open" style="font-size: 3em; color: rgb(220, 220, 220)"></i>
                        <p class="mb-0">Choose images</p>
                        <input type="file" id="images_input" name="image[]" multiple="" data-type="images" class="upload__inputfile" required>
                    </label>
                </div>
                <div id="images_wrap" class="upload__img-wrap upload_images_wrap"></div>
            </div>
            @error('image')
                <div class="alert alert-danger container">{{ $message }}</div>
	        @enderror
	    </div>
        
        <div class="col-12" style="display: flex; text-align: center; gap: 1em">
            <a href="{{ url('/dashboard') }}" class="element-management element-management2 create_product" style="flex: .2">Back</a>
            <button type="submit" class="element-management create_product" style="border: none; flex: .8">Create Product</button>
        </div>
    </form>
</div>

@endsection