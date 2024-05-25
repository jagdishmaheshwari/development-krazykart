@extends('layouts.admin') 

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Manage Sizes
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addSizeModal">
            <i class="fa fa-plus"></i> Add Size
        </button>
    </h2>
    <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover sizeTable">
        <thead>
            <tr>
                <th>Size ID</th>
            <th>Size Name</th>
                <th>Size Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sizes as $size)
            <tr>
                <td>{{ $size->size_id }}</td>
                <td>{{ $size->size_name }}</td>
                <td>{{ $size->size_code }}</td>
                <td>
                    <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editSizeModal"
                        onclick="setEditSizeData('{{ $size->size_name }}', '{{ $size->size_id }}', '{{ $size->size_code }}')">
                        <i class="fa fa-edit"></i> Edit
                    </div>
                    <div class="btn btn-danger" onclick="deleteSize('{{ $size->size_id }}')">
                        <i class="fa fa-trash"></i> Delete
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Size Modal -->
<div class="modal fade" id="addSizeModal" tabindex="1" aria-labelledby="addSizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSizeModalLabel">Add Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Size Form -->
                <form id="addSizeForm">
                    @csrf
                    <div class="mb-3">
                        <label for="sizeName" class="form-label">Size Description:</label>
                        <input type="text" class="form-control" id="sizeName" name="size_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="sizeCode" class="form-label">Size Code:</label>
                        <input type="text" class="form-control" id="sizeCode" name="size_code" required>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary float-end" onclick="addSize()">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Size Modal -->
<div class="modal fade" id="editSizeModal" tabindex="-1" aria-labelledby="editSizeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSizeModalLabel">Edit Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Size Form -->
                <form id="editSizeForm">
                    @csrf
                    <div class="mb-3">
                        <label for="editSizeName" class="form-label">Size Name:</label>
                        <input type="text" class="form-control" id="editSizeName" name="size_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSizeCode" class="form-label">Size Code:</label>
                        <input type="text" class="form-control" id="editSizeCode" name="size_code" required>
                        <input type="hidden" id="editSizeId" name="size_id">
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary float-end" onclick="updateSize()">Update This Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function addSize() {
        var sizeName = $('#sizeName').val();
        var sizeCode = $('#sizeCode').val();

        $.ajax({
            type: 'POST',
            url: '{{ route('admin.size.add') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'size_name': sizeName,
                'size_code': sizeCode
            },
            success: function (response) {
                if (response.status === 'success') {
                    swal({ title: 'Size added successfully!', icon: 'success' }).then(function () {
                        window.location.reload();
                    });
                } else {
                    swal('Failed to add size. Please try again.');
                }
            },
            error: function () {
                swal('An error occurred while adding size. Please try again later.');
            }
        });
    }

    function updateSize() {
        var sizeId = $('#editSizeId').val();
        var sizeName = $('#editSizeName').val();
        var sizeCode = $('#editSizeCode').val();
        
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.size.update') }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'size_id': sizeId,
                'size_name': sizeName,
                'size_code': sizeCode
            },
            success: function (response) {
                if (response.status === 'success') {
                    swal({ title: 'Size updated successfully!', icon: 'success' }).then(function () {
                        window.location.reload();
                    });
                } else {
                    swal('Failed to update size. Please try again.');
                }
            },
            error: function () {
                swal('An error occurred while updating size. Please try again later.');
            }
        });
    }

    function deleteSize(sizeId) {
        swal({
            title: "Are you sure?",
            text: "This action cannot be undone.",
            icon: "warning",
            buttons: ["Cancel", "Confirm"],
            dangerMode: true,
        }).then((isConfirmed) => {
            if (isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.size.delete') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'size_id': sizeId
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            swal({ title: 'Size deleted successfully!', icon: 'success' }).then(function () {
                                window.location.reload();
                            });
                        } else {
                            swal('Failed to delete size. Please try again.');
                        }
                    },
                    error: function () {
                        swal('An error occurred while deleting size. Please try again later.');
                    }
                });
            }
        });
    }

    function setEditSizeData(sizeName, sizeId, sizeCode) {
        $('#editSizeName').val(sizeName);
        $('#editSizeId').val(sizeId);
        $('#editSizeCode').val(sizeCode);
    }
</script>

@endsection