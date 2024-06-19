@extends('layouts.admin')

@section('content')
    <style>
        /* Custom CSS for hover effects */
        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            cursor: pointer;
        }

        .card-img-top {
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }
    </style>
    <div class="container overflow-scroll mt-2  ManageItems">
        <table class="table table-head-bg-primary bg-white table-bordered-bd-primary table-hover" id="itemTable"
            style="min-width:1300px">
            {{-- <colgroup>
                <col style="width:10%">
                <col>
                <col style="width:25%">
            </colgroup> --}}


            {{-- <thead style="padding:0px !important"> --}}
            <tr class="bg-primary text-light">
                <th>Product Name</th>
                <th class="text-center">Available Combination</th>
                <th>Available Stock</th>
                <th>Action</th>
            </tr>
            {{-- </thead> --}}
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_name }}</td>
                        <td>will implement soon</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a class="btn btn-primary"
                                href="{{ route('admin.stock.view.itemwise', [$product->product_id]) }}">View Items</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            $('#productTable').DataTable();
        });
    </script>
@endsection
