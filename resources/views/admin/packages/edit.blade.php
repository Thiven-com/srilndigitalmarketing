@extends('layout.mainlayout') @section('title', 'Edit Package') @section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Edit Package</h4>
                    <h6>Update package details</h6>
                </div>
            </div>
            <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"> <label class="form-label">Name</label> <input type="text"
                                    name="name" value="{{ old('name', $package->name) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Code</label> <input type="text"
                                    name="code" value="{{ old('code', $package->code) }}" class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Price</label> <input type="number"
                                    step="0.01" name="price" value="{{ old('price', $package->price) }}"
                                    class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Joining Amount</label> <input
                                    type="number" step="0.01" name="joining_amount"
                                    value="{{ old('joining_amount', $package->joining_amount) }}" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Renewal Amount</label> <input
                                    type="number" step="0.01" name="renewal_amount"
                                    value="{{ old('renewal_amount', $package->renewal_amount) }}" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3"> <label class="form-label">Short Description</label> <input
                                    type="text" name="short_description"
                                    value="{{ old('short_description', $package->short_description) }}"
                                    class="form-control"> </div>
                            <div class="col-md-12 mb-3"> <label class="form-label">Description</label> <textarea
                                    name="description" rows="5"
                                    class="form-control">{{ old('description', $package->description) }}</textarea> </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Image</label> <input type="file"
                                    name="image" class="form-control"> @if($package->image) <img
                                        src="{{ asset('storage/' . $package->image) }}" width="80" class="mt-2 rounded border">
                                    @endif </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Icon</label> <input type="file"
                                    name="icon" class="form-control"> @if($package->icon) <img
                                        src="{{ asset('storage/' . $package->icon) }}" width="80" class="mt-2 rounded border">
                                    @endif </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Sort Order</label> <input type="number"
                                    name="sort_order" value="{{ old('sort_order', $package->sort_order) }}"
                                    class="form-control"> </div>
                            <div class="col-md-8 mb-3 d-flex align-items-center gap-4">
                                <div class="form-check mt-4"> <input type="checkbox" name="is_popular"
                                        class="form-check-input" id="popular" {{ $package->is_popular ? 'checked' : '' }}>
                                    <label class="form-check-label" for="popular">Popular</label> </div>
                                <div class="form-check mt-4"> <input type="checkbox" name="is_featured"
                                        class="form-check-input" id="featured" {{ $package->is_featured ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Featured</label> </div>
                                <div class="form-check mt-4"> <input type="checkbox" name="status" class="form-check-input"
                                        id="status" {{ $package->status ? 'checked' : '' }}> <label class="form-check-label"
                                        for="status">Active</label> </div>
                            </div>
                        </div>
                        <div class="mt-3"> <button type="submit" class="btn btn-primary">Update Package</button> <a
                                href="{{ route('packages.all') }}" class="btn btn-secondary">Cancel</a> </div>
                    </div>
                </div>
            </form>
        </div>
</div> @endsection