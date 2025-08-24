@extends('layouts.app')
@section('title', 'Brands - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Brands</h5>
            <a href="{{ route('brands.create') }}" class="btn btn-primary">Add Brand</a>
        </div>
        <br>
        <div class="table-responsive">
         <table class="table" id="table">
            <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
              <tr>
                <th scope="row">{{ $brand->id }}</th>
                <td>{{ $brand->name }}</td>
                <td>{{ $brand->status }}</td>
                <td>
                    <a href="{{ route('brands.show', $brand->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('brands.delete', $brand->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
      </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
  <script>
    new DataTable('#table');
  </script>
@endsection
