<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <!-- Modal Content -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="model-1"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- /modal header -->
            <form id="store_or_update_form" method="post">
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <x-form.textbox col="col-md-12" required="required" labelName="Menu Name" name="menu_name"
                            placeholder="Enter menu name" />
                        <x-form.selectbox col="col-md-12" required="required" labelName="Deletable" name="deletable"
                            class="select">
                            @foreach (DELETABLE as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </x-form.selectbox>
                    </div>
                </div>
                <!-- /modal body -->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" id="save-btn"></button>
                </div>
                <!-- /modal footer -->
            </form>

        </div>
        <!-- /modal content -->

    </div>
</div>
