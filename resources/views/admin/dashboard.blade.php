@extends('layouts.app')

@section('navItems')

<li><a href="{{ url('/') }}">Home</a></li>
<li><a href="{{ url('/shop') }}">Shop</a></li>
<li><a href="{{ url('/about') }}">About Us</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>

@endsection

@section('content')

<!-- CREATE CATEGORY MODAL -->
<div class="modal fade" id="createCategory" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('shop/categories') }}" method="POST">
                @csrf
                <div class="modal-header d-flex align-items-center">
                    <h6 class="modal-title mb-0" id="threadModalLabel">| New Category</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input required value="{{ old('name') }}" type="text" class="form-control" name="name" placeholder="Enter name" minlength="4" maxlength="25"/>
                    </div>
                    <div class="modal-footer" style="padding: 0; padding-top: 1em; display: flex; gap: 0.5em">
                        <a type="button" class="btn btn-danger bg-danger text-white" data-dismiss="modal" style="flex: .2; margin: 0; border: 0; border-radius: 0">Cancel</a>
                        <button type="submit" class="btn btn-primary bg-success" style="flex: .8; margin: 0; border: 0; border-radius: 0">Create category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- USERS -->
<div class="container-xl users-management" style="color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div style="width: 100%; display: flex; justify-content: space-between;">
                <p class="element-management element-management2" onclick="changeManagement(this)">Products</p>
                <div style="display: flex; gap: 1em">
                    <p class="element-management element-management2" onclick="changeManagement(this)">Categories</p>
                    <p class="element-management" data-toggle="modal" data-target="#createCategory">Create Category</p>
                </div>
            </div>
            <div class="table-title" style="padding: 16px 30px">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Users <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <button class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></button>						
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="table-export">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>						
                        <th>Email</th>
                        <th>Date Created</th>
                        <th>Role</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- foreach -->
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td id="user-element" data-picture="https://placekitten.com/{{ $rand = rand(100, 200) }}/{{$rand}}"><img src="https://placekitten.com/{{$rand}}/{{$rand}}" class="avatar" alt="Avatar"> {{ $user->name }}</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            <td id="date-element">{{ substr($user->created_at, 0, 10) }}</td>                        
                            <td>@if ($user->role_as != 0)Admin @else User @endif</td>
                            <td>
                                @if ($user->role_as != 1)
                                    <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                        data-bs-target="#deleteElement" data-type="user"
                                        data-name="'{{ $user->name }}' <span style='font-weight: 400'>user</span>" data-url="{{ url('/admin/' . $user->id) }}">
                                        <button class="material-icons delete-button">&#xE5C9;</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

<!-- PRODUCTS -->
<div class="container-xl products-management" style="color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div style="width: 100%; display: flex; justify-content: space-between;">
                <p class="element-management element-management2" onclick="changeManagement(this)">Users</p>
                <div style="display: flex; gap: 1em">
                    <p class="element-management element-management2" onclick="changeManagement(this)">Categories</p>
                    <p class="element-management" data-toggle="modal" data-target="#createCategory">Create Category</p>
                </div>
            </div>
            <div class="table-title" style="padding: 16px 30px">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Products <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <div style="display: flex; justify-content: flex-end">
                            <a href="{{ url('/shop/products/create') }}" class="element-management mb-0 create_product">Create Product</a>
                            <button class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="table-export">
                <thead>
                    <tr>
                        <th>#</th>
                        <th colspan="2">Name</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Color</th>
                        <th>Stock</th>
                        <th>Year</th>
                        <th>Created</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- foreach -->
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td colspan="2"><div style="height: 100%; display: flex; align-items: center"><img src="data:image/jpeg;base64,{{ $product->thumbnail }}" class="avatar"> <a href="{{ url('/shop/products/' . $product->id) }}">{{ $product->name }}</a></div></td>
                            <td>{{ DB::table('brands')->where('id', $product->idBrand)->value('name') }}</td>
                            <td>{{ $product->price }}€</td>
                            <td><div style="display: flex; align-items: center; gap: 0.6em"><div style="background-color: {{ DB::table('colors')->where('id', $product->idColor)->value('hex') }}; width: 1em; height: 1em"></div><p style="margin: 0; color: black; transform: translateY(1.4px)">{{ ucfirst(DB::table('colors')->where('id', $product->idColor)->value('name')) }}</p></div></td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->year }}</td>
                            <td>{{ substr($product->created_at, 0, 10) }}</td>
                            <td>{{ DB::table('categories')->where('id', $product->idCat)->value('name') }}</td>
                            <td>
                                @if (Auth::user()->role_as == 1)
                                    <div style="display: flex;">
                                        <!-- Edit -->
                                        <a href="{{ url('/shop/products/' . $product->id . '/edit') }}" title="Edit" data-toggle="tooltip" data-original-title='Edit'>
                                            <i class="fas fa-edit" style="color: green; margin: 0; transform: translateY(1px)"></i>
                                        </a>
                                        &nbsp;
                                        <!-- Delete -->
                                        <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                        data-bs-target="#deleteElement" data-type="product"
                                        data-name="'{{ $product->name }}' <span style='font-weight: 400'>product</span>" data-url="{{ url('/shop/products/' . $product->id) }}">
                                            <button class="material-icons delete-button">&#xE5C9;</button>
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

<!-- CATEGORIES -->
<div class="container-xl categories-management" style="color: #566787;
    background: #f5f5f5;
    font-family: 'Varela Round', sans-serif;
    font-size: 13px;">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div style="width: 100%; display: flex; justify-content: space-between;">
                <p class="element-management element-management2" onclick="changeManagement(this)">Users</p>
                <p class="element-management" data-toggle="modal" data-target="#createCategory">Create Category</p>
            </div>
            <div class="table-title" style="padding: 16px 30px">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Categories <b>Management</b></h2>
                    </div>
                    <div class="col-sm-7">
                        <button class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></button>						
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="table-export">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- foreach -->
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td id="category-element"> {{ $category->name }}</td>
                            <td>
                                @if (Auth::user()->role_as == 1)
                                    <a href="" class="deleteLinkElement" data-bs-toggle="modal" 
                                        data-bs-target="#deleteElement" data-type="category"
                                        data-name="'{{ $category->name }}' <span style='font-weight: 400'>category</span>" data-url="{{ url('/shop/categories/' . $category->id) }}">
                                        <button class="material-icons delete-button">&#xE5C9;</button>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 

@endsection