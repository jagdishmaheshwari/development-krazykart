@extends('layouts.admin') {{-- Assuming 'layouts.admin' is your admin layout file --}}

@section('content')
    <div class="container mt-3 overflow-scroll">
        <h2 class="text-center">Manage Collections</h2>
        <div class="mb-2 d-flex justify-content-end">
            {{-- <h2>Manage Collections</h2> --}}
            <div>
                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCollectionModal">
                    <i class="fa fa-plus"></i> Add Collection
                </div>
            </div>
        </div>
        <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover" id="categoryTable">
            <thead class="bg-grey">
                <tr>
                    <th style="max-width:20px">ID</th>
                    <th>Collection Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collections as $collection)
                    <tr>
                        <td>{{ $collection->collection_id }}</td>
                        <td>{{ $collection->name }}</td>
                        <td style="width:175px !important">
                            <div class="btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#editCollectionModal"
                                onclick="$('#editCollectionForm #collection_name').val('{{ $collection->name }}');$('#editCollectionForm #collection_id').val('{{ $collection->collection_id }}');">
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="btn btn-danger mt-1" onclick="deleteCollection('{{ $collection->collection_id }}')">
                                <i class="fa fa-trash"></i>
                            </div>
                            <div class="btn btn-success w-100 my-1 "
                                href="{{ route('admin.collection.show', [$collection->collection_id]) }}">
                                <i class="fas fa-grip-horizontal"></i>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add Collection Modal -->
    <div class="modal fade" id="addCollectionModal" tabindex="1" aria-labelledby="addCollectionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCollectionLabel">Add Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add Collection Form -->
                    <form id="addCollectionForm">
                        @csrf
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="collection_name" name="collection_name"
                                placeholder required>
                            <label for="collection_name" class="form-label">Collection Name:</label>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end" onclick="addCollection()">Add
                                Collection</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Collection Modal -->
    <div class="modal fade" id="editCollectionModal" tabindex="-1" aria-labelledby="editCollectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCollectionModalLabel">Edit Collection</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCollectionForm">
                        @csrf
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="collection_name" name="collection_name"
                                placeholder required>
                            <label for="collection_name" class="form-label">Collection Name:</label>
                            <input type="hidden" name="collection_id" id="collection_id" value="">
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary float-end"
                                onclick="updateCollection()">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCollection() {
            var collection_id = $('#editCollectionForm #collection_id').val();
            var collection_name = $('#editCollectionForm #collection_name').val();

            // Check if category name and code are not empty
            if (collection_name.trim() === '') {
                swal('Please enter category name.');
                return;
            }

            // Make AJAX request to update category
            $.ajax({
                type: 'PUT',
                url: '{{ route('admin.collection.update') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'collection_id': collection_id,
                    'collection_name': collection_name
                },
                success: function(response) {
                    if (response.status.trim() === 'success') {
                        showActionAlert('Collection Updated!').then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    showActionAlert(error + '! Collection not updated!', status);
                }
            });
        }

        function addCollection() {
            var collection_name = $('#addCollectionModal #collection_name').val();

            // Check if collection name and code are not empty
            if (collection_name.trim() === '') {
                swal('Collection name is required!');
                return;
            }

            // Make AJAX request to add collection
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.collection.add') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'collection_name': collection_name
                },
                success: function(response) {
                    if (response.status.trim() === 'success') {
                        showActionAlert('New Collection Added!').then(function() {
                            window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    showActionAlert(error + '! Collection not added!', status);
                }
            });
        }

        function deleteCollection(collection_id) {
            swal({
                title: "Sure Delete Collection?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["Cancel", "Confirm"],
                dangerMode: true,
            }).then((isConfirmed) => {
                if (isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('admin.collection.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'collection_id': collection_id
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                showActionAlert('Collection Deleted!').then(function() {
                                    window.location.reload();
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            showActionAlert(error + '! Collection not added!', status);
                        }
                    });
                }
            });
        }
    </script>
@endsection
