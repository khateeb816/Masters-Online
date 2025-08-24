@extends('layouts.app')
@section('title', 'Edit Inventory - ' . config('app.name'))
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventories.update', $inventory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-title">Inventory Information</div>
                    <hr>

                    <div class="form-group">
                        <label for="input-1">Name</label>
                        <input type="text" class="form-control" id="input-1" placeholder="Enter Inventory Name"
                            name="name" value="{{ old('name', $inventory->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="input-2">Category</label>
                        <select class="form-control" id="input-2" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $inventory->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-3">Brand</label>
                        <select class="form-control" id="input-3" name="brand_id">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $inventory->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="input-4">Price</label>
                        <input type="number" step="0.01" class="form-control" id="input-4" placeholder="Enter Price"
                            name="price" value="{{ old('price', $inventory->price) }}">
                    </div>

                    <div class="form-group">
                        <label for="input-5">Discounted Price (Optional)</label>
                        <input type="number" step="0.01" class="form-control" id="input-5" placeholder="Enter Discounted Price"
                            name="discounted_price" value="{{ old('discounted_price', $inventory->discounted_price) }}">
                    </div>

                    <div class="form-group">
                        <label for="input-6">Stock Quantity</label>
                        <input type="number" class="form-control" id="input-6" placeholder="Enter Stock Quantity"
                            name="stock_quantity" value="{{ old('stock_quantity', $inventory->stock_quantity) }}">
                    </div>

                    <div class="form-group">
                        <label for="input-7">Status</label>
                        <select class="form-control" id="input-7" name="status">
                            <option value="active" {{ old('status', $inventory->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $inventory->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Current Images Display -->
                    @if ($inventory->images)
                        <div class="form-group">
                            <label>Current Images</label>
                            <div class="row">
                                @php
                                    $imageArray = json_decode($inventory->images, true);
                                @endphp
                                @if(is_array($imageArray) && count($imageArray) > 0)
                                    @foreach($imageArray as $index => $image)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ asset('uploads/' . $image) }}" alt="Current Image {{ $index + 1 }}"
                                                class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ asset('uploads/' . $inventory->images) }}" alt="Current Image"
                                            class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="input-8">Images</label>
                        <input type="file" class="form-control" id="input-8" name="images[]" multiple accept="image/*">
                        <small class="form-text text-dark">You can select multiple images. Leave empty to keep current images.</small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="zmdi zmdi-save"></i> Update Inventory
                        </button>
                        <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-secondary px-5">
                            <i class="zmdi zmdi-arrow-left"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
