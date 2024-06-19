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
            <tbody>
                <div class="mt-5 row"><?php foreach($items as $item){ ?> <div class="col-md-2 mb-4">
                        <div class="card"><img src="{{ reset($item->item_images) }}"
                                onerror="this.src='/img/image-placeholder-300-500.jpg'" class="card-img-top" alt="item Image">
                            <div class="card-body">
                                <h5 class="card-title">Hello</h5>
                                <p class="card-text">Stock: {{ $item->stock }}</p>
                            </div>
                        </div>
                    </div><?php } ?>
                </div>
            </tbody>
        </table>
    </div>
@endsection
