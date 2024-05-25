@extends('layouts.admin')

@section('content')
    <div class="container mt-5 overflow-scroll">
        <h2 class="mb-4">Manage Colors <button class="btn btn-success mb-3" data-bs-toggle="modal"
                data-bs-target="#addColorModal"><i class="fa fa-plus"></i> Add Color</button>
        </h2>
        <div class="col-10 col-lg-3 my-2 ">
            <form class="input-group" method="GET">
                <input type="text" class="form-control bg-nue" placeholder="Search Category" name="search"
                    value="{{ request('search') }}">
                @if(request('search'))
                    <div class="input-group-text bg-white border-start-0 position-sticky"><a
                            href="{{ route('admin.colors') }}"><i class="fa fa-xmark text-dark"></i></a></div>
                @endif
                <button class="input-group-text"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover colorTable">
            <thead>
                <tr>
                    <th>Color ID</th>
                    <th>Color Name</th>
                    <th>Color Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($colors as $color)
                    <tr>
                        <td>{{ $color->color_id }}</td>
                        <td>{{ $color->color_name }} <i class="fa fa-square" style="font-size:50px;color:{{ $color->color_code }}"></i></td>
                        <td>{{ $color->color_code }} <i class="fa fa-square" style="font-size:50px;color:{{ $color->color_code }}"></i></td>
                        <td>
                            <div class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editColorModal"
                                onclick="$('#editColorForm #colorName').val('{{ $color->color_name }}');$('#editColorForm #colorId').val('{{ $color->color_id }}');$('#editColorForm #colorCode').val('{{ $color->color_code }}');">
                                <i class="fa fa-edit"></i> Edit
                            </div>
                            <div class="btn btn-danger" onclick="deleteColor('{{ $color->color_id }}')"><i
                                    class="fa fa-trash"></i> Delete</div>
                        </td>
                    </tr>
                @empty
                    <tr><th colspan='4'>No Colors Available</th><tr>
                @endforelse
            </tbody>
        </table>
    </div>
<style>
    .colorTable i.fa-square:hover {
        scale: 10;
        transition: 2s;
    }
</style>
    <!-- Add Color Modal -->
    @include('admin.partials.add-color-modal')

    <!-- Edit Color Modal -->
    @include('admin.partials.edit-color-modal')
    
    <script>
        
        function updateColor() {
            // Fetch data from the form
            var colorId = $('#editColorModal #colorId').val();
            var colorName = $('#editColorModal #colorName').val();
            var colorCode = $('#editColorModal #colorCode').val();
            
            // Check if color name and code are not empty
            if (colorName.trim() === '' || colorCode.trim() === '' || colorId.trim() === '') {
                swal('Please enter color name and code.');
            }
            
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.color.update') }}',
                data: {
                    colorId: colorId,
                    colorName: colorName,
                    colorCode: colorCode,
                    _token: '{{ csrf_token() }}'
                },
    success: function (response) {
        // Handle success response
        swal({ title: 'Color updated successfully!', icon: 'success' }).then(function () {
            window.location.reload();
        });
    },
    error: function () {
        // Handle error
        swal('Failed to update color. Please try again.');
    }
});
}
</script>
<!-- Bootstrap JS and Popper.js (Bootstrap 5 requires Popper.js) -->
<script>
    function addColor() {
        // Fetch data from the form
        var colorName = $('#addColorForm #colorName').val();
        var colorCode = $('#addColorForm #colorCode').val();
        // Check if color name and code are not empty
        if (colorName.trim() === '' || colorCode.trim() === '') {
            swal('Please enter color name and code.');
            return;
        }
        
        // Make AJAX request to add color
        $.ajax({
            type: 'POST',
            url: '{{ route("admin.color.add") }}',
            data: {
                colorName: colorName,
                colorCode: colorCode,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                // Handle success response
                swal({ title: 'Color added successfully!', icon: 'success' }).then(function () {
                    window.location.reload();
                });
            },
            error: function () {
                // Handle error
                swal('Failed to add color. Please try again.');
            }
        });
        }
    </script>
    <script>
        // Function to handle color deletion
        function deleteColor(colorId) {
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
                        url: '{{ route('admin.color.delete') }}',
                        data: {
                            colorId: colorId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
        // Handle success response
        swal({ title: 'Color deleted successfully!', icon: 'success' }).then(function () {
            window.location.reload();
        });
    },
    error: function () {
        // Handle error
        swal('Failed to delete color. Please try again.');
    }
});
                }
            });
        }
        
        </script>
@endsection