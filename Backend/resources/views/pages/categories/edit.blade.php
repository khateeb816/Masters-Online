@extends('layouts.app')
@section('title', 'Edit Category - ' . config('app.name'))
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-title">Category Information</div>
                    <hr>

                    <div class="form-group">
                        <label for="input-1">Title</label>
                        <input type="text" class="form-control" id="input-1" placeholder="Enter Your Category Title"
                            name="title" value="{{ old('title', $category->title) }}">
                    </div>
                    <div class="form-group">
                        <label for="input-1">Description</label>
                        <input type="text" class="form-control" id="input-1"
                            placeholder="Enter Your Category Description" name="description"
                            value="{{ old('description', $category->description) }}">
                    </div>
                    <div class="form-group">
                        <label for="input-2">Status</label>
                        <input type="text" class="form-control" id="input-2" placeholder="Enter Your Category Status"
                            name="status" value="{{ old('status', $category->status) }}">
                    </div>
                    @if ($category->image)
                        <div class="form-group">
                            <label for="input-6">Image</label>
                            <img style="width: 150px; height: 150px;" src="{{ asset('uploads/' . $category->image) }}"
                                alt="Image" class="img-fluid">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="input-3">Image</label>
                        <input type="file" class="form-control" id="input-3" name="image"
                            value="{{ old('image', $category->image) }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Update Category</button>
                    </div>
                </form>
            </div>

            <br>
            </form>
        </div>
    </div>
    </div>
@endsection
