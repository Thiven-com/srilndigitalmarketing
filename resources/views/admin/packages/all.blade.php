@extends('layout.mainlayout') @section('title', 'Packages') @section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h4>Packages</h4>
                    <h6>Manage your packages</h6>
                </div>
                <div class="page-btn"> <a href="{{ route('packages.create') }}" class="btn btn-primary"> <i
                            class="ti ti-circle-plus me-1"></i>Add Package </a> </div>
            </div>
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Price</th>
                                    <th>Popular</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> @forelse($packages as $key => $package)
                                <tr>
                                    <td>{{ $packages->firstItem() + $key }}</td>
                                    <td> @if($package->image) <img src="{{ asset('storage/' . $package->image) }}"
                                    width="50" height="50" class="rounded border"> @else <img
                                                src="{{ URL::asset('build/img/users/user-32.jpg') }}" width="50" height="50"
                                            class="rounded border"> @endif </td>
                                    <td>{{ $package->name }}</td>
                                    <td>{{ $package->code ?? '-' }}</td>
                                    <td>₹{{ number_format($package->price, 2) }}</td>
                                    <td> @if($package->is_popular) <span class="badge bg-success">Yes</span> @else <span
                                    class="badge bg-secondary">No</span> @endif </td>
                                    <td> @if($package->is_featured) <span class="badge bg-success">Yes</span> @else <span
                                    class="badge bg-secondary">No</span> @endif </td>
                                    <td> @if($package->status) <span class="badge bg-success">Active</span> @else <span
                                    class="badge bg-danger">Inactive</span> @endif </td>
                                    <td class="action-table-data">
                                        <div class="edit-delete-action">
                                            <!-- Show Button -->
                                            <a href="{{ route('packages.show', $package->id) }}"
                                                class="me-2 p-2 btn btn-sm btn-info text-white" title="View">
                                                <i data-feather="eye" class="feather-eye"></i>
                                            </a>
                                            <a href="{{ route('packages.edit', $package->id) }}" class="me-2 p-2"> <i
                                                    data-feather="edit" class="feather-edit text-primary"></i> </a>
                                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                                class="d-inline"> @csrf @method('DELETE') <button type="submit"
                                                    class="btn btn-link p-2"
                                                    onclick="return confirm('Delete this package?')"> <i
                                                        data-feather="trash-2" class="feather-trash-2 text-danger"></i>
                                                </button> </form>
                                        </div>
                                    </td>
                            </tr> @empty <tr>
                                    <td colspan="9" class="text-center py-4"> No packages found. </td>
                                </tr> @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top"> {{ $packages->links() }} </div>
                </div>
            </div>
        </div>
</div> @endsection