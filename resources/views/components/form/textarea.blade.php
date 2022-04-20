<div class="form-group mb-3 {{ $col ?? '' }} {{ $required ?? '' }}">
    <label for="{{ $name }}">{{ $labelName }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control {{ $name }} {{ $class ?? '' }}"
        placeholder="{{ $placeholder ?? ''}}"></textarea>
</div>
