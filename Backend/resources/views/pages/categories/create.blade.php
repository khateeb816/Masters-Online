@extends('layouts.app')

@section('title', 'Add Category - ' . config('app.name'))

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-title">Category Information</div>
                    <hr>

                    <div class="form-group">
                        <label for="input-1">Title</label>
                        <input type="text" class="form-control" id="input-1" placeholder="Enter Your Category Title"
                            name="title">
                    </div>
                    <div class="form-group">
                        <label for="input-1">Description</label>
                        <textarea name="description" id="input-1" class="form-control" placeholder="Enter Your Category Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-2">Status</label>
                        <select name="status" id="input-2" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="input-3">Image</label>
                        <input type="file" class="form-control" id="input-3" placeholder="Enter Your Category Image"
                            name="image">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-light px-5"><i class="icon-lock"></i> Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
