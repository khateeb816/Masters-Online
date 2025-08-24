@extends('layouts.app')
@section('title', 'Create Promo Code - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('promo-codes.store') }}" method="post">
                @csrf
                <div class="card-title">Promo Code Information</div>
                <hr>

                <div class="form-group">
                    <label for="code">Promo Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                           id="code" placeholder="Enter Promo Code (e.g., SAVE20)"
                           name="code" value="{{ old('code') }}" maxlength="50">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Enter a unique code for the promotion (max 50 characters)</small>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" placeholder="Enter description for this promo code"
                              name="description" rows="3" maxlength="255">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Optional description explaining the promotion</small>
                </div>

                <div class="form-group">
                    <label for="discount_percentage">Discount Percentage</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror"
                               id="discount_percentage" placeholder="Enter discount percentage"
                               name="discount_percentage" value="{{ old('discount_percentage') }}"
                               min="1" max="100">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    @error('discount_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Discount percentage from 1% to 100%</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date" value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">When the promo code becomes active</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">When the promo code expires</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Set whether the promo code is currently active</small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="zmdi zmdi-save"></i> Create Promo Code
                    </button>
                    <a href="{{ route('promo-codes') }}" class="btn btn-secondary px-5">
                        <i class="zmdi zmdi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum start date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('start_date').min = today;

    // Update end date minimum when start date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
});
</script>
@endsection
