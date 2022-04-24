<div class="form-group mb-3 {{ $col ?? '' }} {{ $required ?? '' }}">
    <label for="{{ $name }}">{{ $labelName }}</label>
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}"
        class="form-control {{ $name }} {{ $class ?? '' }}" placeholder="{{ $placeholder ?? ''}}"
        value="{{ $value ?? '' }}" @if(!empty($onkeyup)) onkeyup="{{ $onkeyup ?? '' }}" @endif>
</div>
