@extends('layouts.app')

@section('title')
{{ $page_title }}
@endsection

@push('styles')

@endpush

@section('content')
<div class="dt-content">

    <!-- Grid -->
    <div class="row">

        <!-- Grid Item -->
        <div class="col-xl-12">

            <!-- Entry Header -->
            <div class="dt-entry__header">

                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h2 class="dt-entry__title"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h2>
                </div>
                <!-- /entry heading -->
                <button class="btn btn-primary btn-sm" onclick="showFormModal('Add New Menu','Save')"><i
                        class="fas fa-plus-square"></i> Add New</button>
            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <!-- Tables -->
                    <div class="table-responsive">

                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select_all"
                                                onchange="select_all()">
                                            <label class="custom-control-label" for="select_all"></label>
                                        </div>
                                    </th>
                                    <th>Sl</th>
                                    <th>Menu Name</th>
                                    <th>Deletable</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                    <!-- /tables -->

                </div>
                <!-- /card body -->

            </div>
            <!-- /card -->

        </div>
        <!-- /grid item -->

    </div>
    <!-- /grid -->

</div>
@include('menu.modal')
@endsection

@push('scripts')
<script>
    var table;
    $(document).ready(function () {

    });

</script>
@endpush
