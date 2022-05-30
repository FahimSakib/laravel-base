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
                            <button class="btn btn-primary btn-sm" onclick="showFormModal('Add New Menu','Save')"><i
                                    class="fas fa-plus-square"></i> Add New</button>
                        </div>
                        <!-- /entry header -->

                        <!-- Card -->
                        <div class="dt-card">

                            <!-- Card Body -->
                            <div class="dt-card__body">
                                <form id="saveDataForm" method="post">
                                    @csrf
                                    <div class="row">
                                        <x-form.textbox labelName="Role Name" name="role_name" required="required"
                                            col="col-md-12" placeholder="Enter role name" />
                                        <div class="col-md-12">
                                            <ul id="permission" class="text-left">
                                                @if (!$data->isEMpty())
                                                @foreach ($data as $menu)
                                                @if ($menu->submenu->isEmpty())
                                                <li>
                                                    <input type="checkbox" name="module[]" class="module"
                                                        value="{{ $menu->id }}">
                                                    {{ $menu->type == 1 ? $menu->divider_title : $menu->module_name }}
                                                    @if (!$menu->permission->isEmpty())
                                                    <ul>
                                                        @foreach ($menu->permission as $permission)
                                                        <li><input type="checkbox" name="permission[]"
                                                                value="{{ $permission->id }}" />{{ $permission->name }}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                                @else
                                                <li>
                                                    <input type="checkbox" name="module[]" class="module"
                                                        value="{{ $menu->id }}">
                                                    {{ $menu->type == 1 ? $menu->divider_title : $menu->module_name }}
                                                    <ul>
                                                        @foreach ($menu->submenu as $submenu)
                                                        <li>
                                                            <input type="checkbox" name="module[]" class="module"
                                                                value="{{ $submenu->id }}"> {{ $submenu->module_name }}
                                                            @if (!$submenu->permission->isEmpty())
                                                            <ul>
                                                                @foreach ($submenu->permission as $permission)
                                                                <li><input type="checkbox" name="permission[]"
                                                                        value="{{ $permission->id }}" />{{ $permission->name }}
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                            @endif
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                                @endif
                                                @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="col-md-12 pt-4">
                                            <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                id="save-btn">Save</button>
                                        </div>
                                    </div>
                                </form>
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
<script src="js/tree.js"></script>
<script>
$(document).ready(function () {
    $('input[type=checkbox]').click(function () {
        $(this).next().find('input[type=checkbox]').prop('checked', this.checked);
        $(this).parents('ul').prev('input[type=checkbox]').prop('checked', function () {
            return $(this).next().find(':checked').length;
        });
    });

    $('#permission').treed(); //intialized tree js
});
</script>
@endpush
