@extends('admin.customers.customer_menu')
@section('customer')
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="tab-content">

                <div class="tab-pane fade show active">
                    <h5 class="mb-3">Profile Information</h5>

                    <div class="row mb-3">
                        <div class="col-4 text-muted">Full Name</div>
                        <div class="col-8 fw-semibold">{{ $customer->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 text-muted">Email</div>
                        <div class="col-8">{{ $customer->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4 text-muted">Phone</div>
                        <div class="col-8">{{ $customer->mobile ?? '—' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4 text-muted">Date of Birth</div>
                        <div class="col-8">{{ Carbon\Carbon::parse($customer->dob)->format('d-m-Y') ?? '—' }}</div>
                    </div>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        Edit Profile
                    </button>
                    <button class="btn btn-dark ms-2" data-bs-toggle="modal" data-bs-target="#updateSponsorModal">
                        Update Sponsor ID
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="profileFormModal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="modalName" class="form-label">Full Name</label>
                            <input type="text" id="modalName" class="form-control" value="{{ $customer->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="modalEmail" class="form-label">Email</label>
                            <input type="email" id="modalEmail" class="form-control" value="{{ $customer->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="modalMobile" class="form-label">Mobile Number</label>
                            <input type="text" id="modalMobile" class="form-control" value="{{ $customer->mobile }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="updateProfileModalBtn" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Sponsor Modal -->
    <div class="modal fade" id="updateSponsorModal" tabindex="-1" aria-labelledby="updateSponsorModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-md">

            <div class="modal-content border-0 shadow-lg">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="updateSponsorModalLabel">
                        Update Sponsor ID
                    </h5>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="alert alert-warning small">
                        Changing sponsor ID may affect referral structure and income calculations.
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Current Sponsor ID
                        </label>

                        <input type="text" class="form-control bg-light" value="{{ $customer->sponsor_id ?? 'N/A' }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label for="newSponsorId" class="form-label fw-semibold">
                            New Sponsor ID
                        </label>

                        <input type="text" id="newSponsorId" class="form-control" placeholder="Enter Sponsor ID">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="button" id="updateSponsorBtn" class="btn btn-dark">
                        Update Sponsor
                    </button>
                </div>

            </div>

        </div>

    </div>

    <script>
        document.getElementById('updateProfileModalBtn').addEventListener('click', async function () {

            const payload = {
                name: document.getElementById('modalName').value.trim(),
                email: document.getElementById('modalEmail').value.trim(),
                mobile: document.getElementById('modalMobile').value.trim(),
            };

            if (!payload.name || !payload.email || !payload.mobile) {
                return alert('Name, email and mobile are required.');
            }

            try {

                const response = await fetch("#", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    alert('Profile updated successfully!');
                    location.reload();
                } else {
                    alert(data.message || 'Failed to update profile.');
                }

            } catch (err) {
                console.error(err);
                alert('Error updating profile.');
            }

        });
    </script>

    <script>

        document.getElementById('updateSponsorBtn')
            .addEventListener('click', async function () {

                const sponsor_id = document
                    .getElementById('newSponsorId')
                    .value
                    .trim();

                if (!sponsor_id) {
                    return alert('Please enter sponsor ID.');
                }

                try {

                    const response = await fetch(
                        "#",
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                sponsor_id: sponsor_id
                            })
                        }
                    );

                    const data = await response.json();

                    if (data.success) {

                        alert(data.message);

                        location.reload();

                    } else {

                        alert(data.message || 'Failed to update sponsor.');

                    }

                } catch (err) {

                    console.error(err);

                    alert('Something went wrong.');

                }

            });

    </script>
@endsection