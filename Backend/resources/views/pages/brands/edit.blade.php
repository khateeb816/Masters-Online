@extends('layouts.app')
@section('title', 'Edit Brand - ' . config('app.name'))
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('brands.update', $brand->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-title">Brand Information</div>
                    <hr>

                    <div class="form-group">
                        <label for="input-1">Name</label>
                        <input type="text" class="form-control" id="input-1" placeholder="Enter Your Brand Name"
                            name="name" value="{{ old('name', $brand->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="input-1">Description</label>
                        <input type="text" class="form-control" id="input-1"
                            placeholder="Enter Your Brand Description" name="description"
                            value="{{ old('description', $brand->description) }}">
                    </div>
                    <div class="form-group">
                        <label for="input-2">Status</label>
                        <input type="text" class="form-control" id="input-2" placeholder="Enter Your Brand Status"
                            name="status" value="{{ old('status', $brand->status) }}">
                    </div>
                    @if ($brand->image)
                        <div class="form-group">
                            <label for="input-6">Image</label>
                            <img style="width: 150px; height: 150px;" src="{{ asset('uploads/' . $brand->image) }}"
                                alt="Image" class="img-fluid">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="input-3">Image</label>
                        <input type="file" class="form-control" id="input-3" name="image"
                            value="{{ old('image', $brand->image) }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Update Brand</button>
                    </div>
                </form>
            </div>

            <br>
            </form>
        </div>
    </div>
    </div>
@endsection
