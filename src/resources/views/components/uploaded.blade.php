<?php
/**
 * Uppish: Uploaded File Snippet.
 *
 * This component is to display the uploaded files and
 * allow the user to delete the files as well. This
 * is for the easy integration in blade templates.
 *
 * Attributes:
 * - name: (string) - mandatory - Accepts string only.
 * - file: (string) - mandatory - File to be deleted.
 *
 * INSTRUCTIONS TO OVERRIDE:
 * - all the %%UPPISH_*%% strings are unchangeable and fixed
 * - all the '.js-uppish-*' and '.uppish-*' classes are mandatory
 * - the hidden field with a name and value is mandatory
 * - the button with class '.js-uppish-delete-file' with a data-file="" attribute is mandatory
 * - the button type should be 'button'
 *
 * IF YOU CHANGE THE MARKUP, CONSIDER CHANGING THE MARKUP IN `inputElem()` FUNCTION IN THE `uppish.js`.
 */
?>

@props(['name', 'file'])

@php
    $filename  = isset($file) ? basename($file) : '';
    $publicURL = isset($file) ? Uppish::getFileURL($file) : '';
@endphp

<div class="js-uppish-uploaded-file position-relative my-1 clearfix">
    <input type="hidden" class="js-uppish-file" name="{{ $name }}" value="{{ $file }}">
    <a class="btn btn-block btn-info text-white text-left pr-5" href="{{ $publicURL }}" target="_blank" rel="noopener">
        {{ $filename }}
    </a>
    <button type="button" class="js-uppish-delete-file float-right btn rounded-pill" data-file="{{ $file }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="align-top mr-1">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="9" y1="9" x2="15" y2="15"></line>
            <line x1="15" y1="9" x2="9" y2="15"></line>
        </svg>
        <span class="sr-only">Delete {{ $filename }}</span>
    </button>
</div>
