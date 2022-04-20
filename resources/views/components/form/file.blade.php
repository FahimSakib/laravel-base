<div class="form-group mb-3 {{ $col ?? '' }} {{ $required ?? '' }}">
    <input type="file" class="dropify {{ $class ?? '' }}" name="{{ $name }}" id="{{ $name }}"
        data-errors-position="outside" data-allowed-file-extensions="png jpeg jpg" data-max-file-size="1M">
    <input type="text" class="d-none" name="old_{{ $name }}" id="old_{{ $name }}">
</div>
