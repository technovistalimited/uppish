<?php
/**
 * Uppish: File input.
 *
 * This component is to allow easy integration into any form within
 * blade templates. There are mandatory and optional attributes
 * available to tweak the design according to necessity.
 *
 * Attributes:
 * - name:       (string) - mandatory - Accepts string or string-array; eg. 'file' for single file, 'files[]' for multiple.
 * - isRequired: (boolean) - optional - True if the field is required, false by default.
 * - accept:     (string)  - optional - Accepts comma separated extensions or MIME types. Default: config('uppish.accepted_extensions').
 * - size:       (integer) - optional - Value in binary bytes. Default: config('uppish.upload_max_size').
 * - limit:      (integer) - optional - Value in number. Default and Max.: config('uppish.maximum_files').
 * - groupClass: (string)  - optional - Group item HTML class. Default: ''.
 * - btnClass:   (string)  - optional - Button item HTML class. Default: Bootstrap4 .btn.btn-outline-secondary.
 * - btnText:    (string)  - optional - Button item text. Default: 'Browse…'.
 * - fieldId:    (string)  - optional - Input type file HTML id. Default: ''.
 * - fieldClass: (string)  - optional - Input type file HTML class. Default: ''.
 * - files:      (string|array) - optional - To display uploaded files in edit mode. Default: ''.
 */
?>

@props([
    'name', // eg. 'attachment' for single item, 'attachments[]' for multiple items.
    'isRequired' => false,
    'accept'     => null,
    'size'       => null, // in binary bytes.
    'limit'      => null, // in number.
    'groupClass' => '',
    'btnClass'   => 'btn btn-outline-secondary',
    'btnText'    => '',
    'fieldId'    => '',
    'fieldClass' => '',
    'files'      => '', // string/array of files. (Used to display data in edit mode)
])

@php
    // If there is a single file in a field, then make the mandatory field optional.
    if(is_array($files) && count($files) > 0) {
        $isRequired = false;
    }elseif(!empty($files)) {
        $isRequired = false;
    }
@endphp

<div class="uppish {{ $groupClass }}">
    <div class="btn-uppish {{ $btnClass }}" tabindex="-1">
        <span>{{ $btnText ? $btnText : __('Browse') . '…' }}</span>
        <input type="file" data-name="{{ $name }}"
            {{ $attributes->merge(['class' => "js-uppish {$fieldClass}"]) }}
            @if ($fieldId)
                {{ $attributes->merge(['id' => "$fieldId"]) }}
            @endif
            accept="{{ $accept ?? config('uppish.accepted_extensions') }}"
            {{ $isRequired ? ' required' : '' }}
            @if($size)
                data-size="{{ intval($size) }}"
            @endif
            @if($limit)
                data-limit="{{ intval($limit) }}"
            @endif
            >
    </div>
    <div class="uppish-uploads">
        @if(is_array($files) && count($files) > 0)
            @foreach($files as $file)
                <x-uppish::uploaded name="{{ $name }}" file="{{ $file }}" />
            @endforeach
        @elseif(!empty($files))
            <x-uppish::uploaded name="{{ $name }}" file="{{ $files }}" />
        @endif
    </div>
</div>
