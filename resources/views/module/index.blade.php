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
        <div class="col-xl 12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="active breadcrumb-item">{{ $sub_title }}</</li> </ol> </div> <!-- Grid Item -->
                    <div class="col-xl-12">

                        <!-- Entry Header -->
                        <div class="dt-entry__header">

                            <!-- Entry Heading -->
                            <div class="dt-entry__heading">
                                <h2 class="dt-entry__title"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h2>
                            </div>
                            <!-- /entry heading -->
                            <a class="btn btn-primary btn-sm" href=""><i
                                    class="fas fa-plus-square"></i> Add New</a>
                        </div>
                        <!-- /entry header -->

                        <!-- Card -->
                        <div class="dt-card">

                            <!-- Card Body -->
                            <div class="dt-card__body">

                            </div>
                            <!-- /card body -->

                        </div>
                        <!-- /card -->

                    </div>
                    <!-- /grid item -->

        </div>
        <!-- /grid -->

    </div>
@endsection

@push('scripts')
<script>

</script>
@endpush
