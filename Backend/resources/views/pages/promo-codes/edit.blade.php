@extends('layouts.app')
@section('title', 'Edit Promo Code - ' . config('app.name'))

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('promo-codes.update', $promoCode->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card-title">Edit Promo Code Information</div>
                <hr>

                <div class="form-group">
                    <label for="code">Promo Code</label>
                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                           id="code" placeholder="Enter Promo Code (e.g., SAVE20)"
                           name="code" value="{{ old('code', $promoCode->code) }}" maxlength="50">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-dark">Enter a unique code for the promotion (max 50 characters)</small>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" placeholder="Enter description for this promo code"
                              name="description" rows="3" maxlength="255">{{ old('description', $promoCode->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-dark">Optional description explaining the promotion</small>
                </div>

                <div class="form-group">
                    <label for="discount_percentage">Discount Percentage</label>
                    <div class="input-group">
                        <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror"
                               id="discount_percentage" placeholder="Enter discount percentage"
                               name="discount_percentage" value="{{ old('discount_percentage', $promoCode->discount_percentage) }}"
                               min="1" max="100">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    @error('discount_percentage')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-dark">Discount percentage from 1% to 100%</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                   id="start_date" name="start_date"
                                   value="{{ old('start_date', $promoCode->start_date->format('Y-m-d')) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-dark">When the promo code becomes active</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                   id="end_date" name="end_date"
                                   value="{{ old('end_date', $promoCode->end_date->format('Y-m-d')) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-dark">When the promo code expires</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="active" {{ old('status', $promoCode->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $promoCode->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-dark">Set whether the promo code is currently active</small>
                </div>

                <!-- Current Usage Warning -->
                @if($promoCode->orders->count() > 0)
                <div class="alert alert-warning">
                    <i class="zmdi zmdi-alert-triangle mr-2"></i>
                    <strong>Warning:</strong> This promo code has been used in {{ $promoCode->orders->count() }} order(s).
                    Changing it may affect existing orders.
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="zmdi zmdi-save"></i> Update Promo Code
                    </button>
                    <a href="{{ route('promo-codes.show', $promoCode->id) }}" class="btn btn-secondary px-5">
                        <i class="zmdi zmdi-arrow-left"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update end date minimum when start date changes
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });

    // Set initial end date minimum
    const startDate = document.getElementById('start_date').value;
    if (startDate) {
        document.getElementById('end_date').min = startDate;
    }
});
</script>
@endsection
