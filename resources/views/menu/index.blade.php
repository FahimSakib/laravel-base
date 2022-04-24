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
                <li class="active breadcrumb-item">{{ $sub_title }}</</li>
            </ol>
        </div>
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
        table = $('#dataTable').DataTable({
            "processing": true, //Feature control the processing indicator
            "serverSide": true, //Feature control DataTable server side processing mode
            "order": [], //Initial no order
            "responsive": true, //Make table responsive in mobile device
            "bInfo": true, //TO show the total number of data
            "bFilter": false, //For datatable default search box show/hide
            "lengthMenu": [
                [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
            ],
            "pageLength": 5, //number of data show per page
            "language": {
                processing: `<i class="fas fa-spinner fa-spin fs-3x fa-fw text-primary"></i>`,
                emptyTable: '<strong class="text-danger">No Data Found</strong>',
                infoEmpty: '',
                zeroRecords: '<strong class="text-danger">No Data Found</strong>'
            },
            "ajax": {
                "url": "{{route('menu.datatable.data')}}",
                "type": "POST",
                "data": function (data) {
                    data._token = _token;
                }
            },
            "columnDefs": [{
                    "targets": [0,4],
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "targets": [1,3],
                    "className": "text-center"
                }
            ],
            "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'<'float-right'B>>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",
            "buttons": [
                {
                    'extend':'colvis','className':'btn btn-secondary btn-sm text-white','text':'Column'
                },
                {
                    "extend": 'print',
                    'text':'Print',
                    'className':'btn btn-secondary btn-sm text-white',
                    "title": "Menu List",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    },
                    customize: function (win) {
                        $(win.document.body).addClass('bg-white');
                    },
                },
                {
                    "extend": 'csv',
                    'text':'CSV',
                    'className':'btn btn-secondary btn-sm text-white',
                    "title": "Menu List",
                    "filename": "menu-list",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    }
                },
                {
                    "extend": 'excel',
                    'text':'Excel',
                    'className':'btn btn-secondary btn-sm text-white',
                    "title": "Menu List",
                    "filename": "menu-list",
                    "exportOptions": {
                        columns: function (index, data, node) {
                            return table.column(index).visible();
                        }
                    }
                },
                {
                    "extend": 'pdf',
                    'text':'PDF',
                    'className':'btn btn-secondary btn-sm text-white',
                    "title": "Menu List",
                    "filename": "menu-list",
                    "orientation": "landscape", //portrait
                    "pageSize": "A4", //A3,A5,A6,legal,letter
                    "exportOptions": {
                        columns: [1,2,3]
                    },
                },
                {
                    'className':'btn btn-danger btn-sm delete_btn d-none text-white',
                    'text':'Delete',
                    action:function(e,dt,node,config){
                        multi_delete();
                    }
                }
            ],
        });

        $('#btn-filter').click(function () {
            table.ajax.reload();
        });

        $('#btn-reset').click(function () {
            $('#form-filter')[0].reset();
            table.ajax.reload();
        });

        $(document).on('click', '#save-btn', function () {
            let form = document.getElementById('store_or_update_form');
            let formData = new FormData(form);
            let url = "{{route('menu.store.or.update')}}";
            let id = $('#update_id').val();
            let method;
            if (id) {
                method = 'update';
            } else {
                method = 'add';
            }
            store_or_update_data(table, method, url, formData);
        });

        $(document).on('click', '.edit_data', function () {
            let id = $(this).data('id');
            $('#store_or_update_form .selectpicker').val('').trigger('change');
            if (id) {
                $.ajax({
                    url: "{{route('menu.edit')}}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: _token
                    },
                    dataType: "JSON",
                    success: function (data) {
                        $('#store_or_update_form #update_id').val(data.data.id);
                        $('#store_or_update_form #menu_name').val(data.data.menu_name);
                        $('#store_or_update_form #deletable').val(data.data.deletable).trigger('change');
                        $('#store_or_update_modal').modal({
                            keyboard: false,
                            backdrop: 'static',
                        });
                        $('#store_or_update_modal .modal-title').html(
                            '<i class="fas fa-edit"></i> <span>Edit ' + data.data.menu_name + '</span>');
                        $('#store_or_update_modal #save-btn').text('update');
                    },
                    error: function (xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                    }
                });
            }
        });

        $(document).on('click', '.delete_data', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let row = table.row($(this).parent('tr'));
            let url = "{{ route('menu.delete') }}";
            delete_data(id, url, table, row, name);
        });

        function multi_delete() {
            let ids = [];
            let rows;
            $('.select_data:checked').each(function () {
                ids.push($(this).val());
                rows = table.rows($('.select_data:checked').parents('tr'));
            });
            if (ids.length == 0) {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Please checked at least one row of table!',
                    icon: 'warning',
                });
            } else {
                let url = "{{route('menu.bulk.delete')}}";
                bulk_delete(ids, url, table, rows);
            }
        }

    });

</script>
@endpush
