@extends('layouts.app')
@section('title', 'Inventories - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Inventories</h5>
            <a href="{{ route('inventories.create') }}" class="btn btn-primary">Add Inventory</a>
        </div>
        <br>
        <div class="table-responsive">
         <table class="table" id="table">
            <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Brand</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
              <tr>
                <th scope="row">{{ $inventory->id }}</th>
                <td>{{ $inventory->name }}</td>
                <td>{{ $inventory->category->title }}</td>
                <td>{{ $inventory->brand->name }}</td>
                <td>{{ $inventory->price }}</td>
                <td>{{ $inventory->stock_quantity }}</td>
                <td>{{ $inventory->status }}</td>
                <td>
                    <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('inventories.delete', $inventory->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this inventory?')">Delete</a>
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
