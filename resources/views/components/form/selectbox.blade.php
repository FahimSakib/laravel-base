<div class="form-group mb-3 {{ $col ?? '' }} {{ $required ?? '' }}">
    <label for="{{ $name }}">{{ $labelName }}</label>
    <select class="form-select {{ $name ?? '' }} {{ $class ?? '' }}" aria-label="Default select example"
        name="{{ $name }}" id="{{ $name }}" @if (!empty($onchange)) onchange="{{ $onchange ?? ''}}" @endif
        data-live-search="true" data-live-search-placeholder="Search" title="Choose one of the following">
        <option value="">Select Please</option>
        {{ $slot }}
    </select>
</div>