@extends('layouts.app')

@section('title', 'Add Inventory - ' . config('app.name'))

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-title">Inventory Information</div>
                    <hr>

                    <div class="form-group">
                        <label for="input-name">Name</label>
                        <input type="text" class="form-control" id="input-name" placeholder="Enter Inventory Name"
                            name="name">
                    </div>
                    <div class="form-group">
                        <label for="input-description">Description</label>
                        <textarea name="description" id="input-description" class="form-control" placeholder="Enter Inventory Description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-category">Category</label>
                        <select name="category_id" id="input-category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-brand">Brand</label>
                        <select name="brand_id" id="input-brand" class="form-control">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-price">Price</label>
                        <input type="number" class="form-control" id="input-price" placeholder="Enter Price"
                            name="price" min="0">
                    </div>
                    <div class="form-group">
                        <label for="input-discounted-price">Discounted Price</label>
                        <input type="number" class="form-control" id="input-discounted-price" placeholder="Enter Discounted Price"
                            name="discounted_price" min="0">
                    </div>
                    <div class="form-group">
                        <label for="input-stock-quantity">Stock Quantity</label>
                        <input type="number" class="form-control" id="input-stock-quantity" placeholder="Enter Stock Quantity"
                            name="stock_quantity" min="0">
                    </div>
                    <div class="form-group">
                        <label for="input-status">Status</label>
                        <select name="status" id="input-status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-images">Images</label>
                        <input type="file" class="form-control" id="input-images" name="images[]" multiple>
                        <small class="form-text text-dark">You can upload multiple images.</small>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
