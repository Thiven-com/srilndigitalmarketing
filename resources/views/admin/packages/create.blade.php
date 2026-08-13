@extends('layout.mainlayout') @section('title', 'Create Package') @section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Create Package</h4>
                    <h6>Add a new package</h6>
                </div>
            </div>
            <form action="{{ route('packages.store') }}" method="POST" enctype="multipart/form-data"> @csrf <div
                    class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3"> <label class="form-label">Name</label> <input type="text"
                                    name="name" class="form-control" required> </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Code</label> <input type="text"
                                    name="code" class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Price</label> <input type="number"
                                    step="0.01" name="price" class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Joining Amount</label> <input
                                    type="number" step="0.01" name="joining_amount" class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Renewal Amount</label> <input
                                    type="number" step="0.01" name="renewal_amount" class="form-control"> </div>
                            <div class="col-md-12 mb-3"> <label class="form-label">Short Description</label> <input
                                    type="text" name="short_description" class="form-control"> </div>
                            <div class="col-md-12 mb-3"> <label class="form-label">Description</label> <textarea
                                    name="description" rows="5" class="form-control"></textarea> </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Image</label> <input type="file"
                                    name="image" class="form-control"> </div>
                            <div class="col-md-6 mb-3"> <label class="form-label">Icon</label> <input type="file"
                                    name="icon" class="form-control"> </div>
                            <div class="col-md-4 mb-3"> <label class="form-label">Sort Order</label> <input type="number"
                                    name="sort_order" value="0" class="form-control"> </div>
                            <div class="col-md-8 mb-3 d-flex align-items-center gap-4">
                                <div class="form-check mt-4"> <input type="checkbox" name="is_popular"
                                        class="form-check-input" id="popular"> <label class="form-check-label"
                                        for="popular">Popular</label> </div>
                                <div class="form-check mt-4"> <input type="checkbox" name="is_featured"
                                        class="form-check-input" id="featured"> <label class="form-check-label"
                                        for="featured">Featured</label> </div>
                                <div class="form-check mt-4"> <input type="checkbox" name="status" class="form-check-input"
                                        id="status" checked> <label class="form-check-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3"> <button type="submit" class="btn btn-primary">Save Package</button> <a
                                href="{{ route('packages.all') }}" class="btn btn-secondary">Cancel</a> </div>
                    </div>
                </div>
            </form>
        </div>
</div> @endsection