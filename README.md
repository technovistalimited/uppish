# Uppish

## Table of Contents

<!-- MarkdownTOC -->

- [Start development](#start-development)
    - [Step 1: Put the package in place](#step-1-put-the-package-in-place)
    - [Step 2: Add the repository to your app](#step-2-add-the-repository-to-your-app)
        - [`composer.json`](#composerjson)
    - [Step 3: Let the composer do the rest](#step-3-let-the-composer-do-the-rest)
        - [Providers array](#providers-array)
        - [Aliases array](#aliases-array)
    - [Step 4: Publish the Necessary files](#step-4-publish-the-necessary-files)
- [How to use](#how-to-use)
    - [form blade](#form-blade)
    - [Add Mode](#add-mode)
    - [Edit Mode](#edit-mode)
        - [**Blade files**](#blade-files)
        - [**Controller**](#controller)
    - [Get File URL](#get-file-url)
    - [Get Image URL](#get-image-url)
    - [Pluggability](#pluggability)
        - [`isRequired`](#isrequired)
        - [`accept`](#accept)
        - [`size`](#size)
        - [`fieldId`](#fieldid)
        - [`fieldClass`](#fieldclass)
        - [`limit`](#limit)
        - [`groupClass`](#groupclass)
        - [`btnClass`](#btnclass)
        - [`btnText`](#btntext)
    - [Overriding things](#overriding-things)
        - [Overriding Routes](#overriding-routes)
- [Credits](#credits)
- [Wishlists](#wishlists)

<!-- /MarkdownTOC -->


## Start development

### Step 1: Put the package in place

Get to your project root, and run the following command:

```shell
git clone git@github.com:technovistalimited/uppish.git packages/technovistalimited/uppish/
```

> ⚠️ **REMOVE `.git` DIRECTORY** ⚠️
> Don't forget to remove `.git` directory from the `packages/technovistalimited/uppish/` path if you have a global version controlling in your project. You can use the following command right after the cloning:<br>
> `cd packages/technovistalimited/uppish/ && rm -rf .git`

### Step 2: Add the repository to your app

#### `composer.json`

Open up the `composer.json` of your app root and add the following line under `psr-4` `autoload` array:

```json
"Technovistalimited\\Uppish\\": "packages/technovistalimited/uppish/src"
```

So that it would look similar to:

```json
"autoload": {
    "psr-4": {
        "Technovistalimited\\Uppish\\": "packages/technovistalimited/uppish/src"
    }
}
```

### Step 3: Let the composer do the rest

Open up the command console on the root of your app and run:

```shell
composer dump-autoload
```

#### Providers array

Add the following string to `config/app.php` under `providers` array:

```php
Technovistalimited\Uppish\UppishServiceProvider::class,
```

#### Aliases array

Add the following line to the `config/app.php` under `aliases` array:

```php
'Uppish' => Technovistalimited\Uppish\Facades\Uppish::class,
```

### Step 4: Publish the Necessary files

Make the configuration and view files ready first:

```shell
php artisan vendor:publish --tag=uppish
```

## How to use

### Load styles and Scripts

Add the necessary stylesheets and javascripts.

```php
@push('styles')
    /*
    If you want to use the default styling of Uppish.
    <link rel="stylesheet" href="path/to/bootstrap-4.min.css"> */
    <link rel="stylesheet" href="{{ asset('vendor/uppish/css/uppish.css') }}">
    /* <link rel="stylesheet" href="{{ asset('vendor/uppish/css/interface.css') }}"> */
@endpush
```

```php
@push('scripts')
    // Pass uppish PHP data into JavaScripts.
    @include('vendor.uppish.php-js')

    <!--
    Uppish is Dependent to jQuery.
    <script src="path/to/jquery-3.6.min.js"></script> -->
    <script src="{{ asset('vendor/uppish/js/uppish.js') }}"></script>
@endpush
```

Where you need to add file upload feature, simply add the following:

```php
<x-uppish::files name="image" />
```

If you have to add multiple files, use `array` notation in the `name` attribute:

```php
<x-uppish::files name="images[]" />
```

> **📣 FOR MORE PLUGGABILITY SEE THE [PLUGGABILITY](#pluggability) SECTION**

### Add Mode

```php
public function store(Request $request)
{
    $upload = Uppish::upload($request->upload); // Returns array of arrays.

    // dd($upload[0]['file']); // single file
    // Or, for multiple files, loop through $upload
}
```

### Edit Mode

#### **Blade files**

Pass the information of already uploaded files in a string (for single file) or in an array (for multiple files).

```php
// $file = 'public/uploads/2021/04/1617194983-My-Document.pdf';

// Note the colon (:) before 'files'.
<x-uppish::files name="upload" :files="$file" />

// $files = array(
//     'public/uploads/2021/04/1617194983-My-Document.pdf',
//     'public/uploads/2021/04/1617194987-Profile-image.png',
// );

// Note the colon (:) before 'files'.
<x-uppish::files name="upload[]" :files="$files" />
```

#### **Controller**

```php
public function update(Request $request, $id)
{
    // $item = Item::findorfail($id);
    $upload = Uppish::upload($request->upload); // Returns array of arrays.

    if (!empty($upload)) {
        // New file to be updated, so delete the old file.
        if (!empty($item->upload)) {
            Uppish::delete($item->upload);

            // dd($upload[0]['file']); // single file
            // Or, for multiple files, loop through $upload
        }

    }
}
```

### Get File URL

Dependent to `php artisan storage:link`.

```php
$fileURL  = Uppish::getFileURL($file);
```

### Get Image URL

Dependent to `php artisan storage:link`.

```php
$originalImageURL  = Uppish::getFileURL($image);
$originalImageURL  = Uppish::getImageURL($image);
$originalImageURL  = Uppish::getImageURL($image, 'original');
$thumbnailImageURL = Uppish::getImageURL($image, 'tmb');
$mediumImageURL    = Uppish::getImageURL($image, 'med');
```

### Pluggability

There are many ways you can plug per-scope settings into each of the `<input type="file">` element.

#### `isRequired`

Accepts: _(boolean)_ True/False<br>
Default: `false` (not required)

```php
<x-uppish::files isRequired="true" />
```

#### `accept`

Accepts: _(string)_ file extensions/MIME types (comma separated)<br>
Default: `config('uppish.accepted_extensions')`

```php
<x-uppish::files accept="jpg, png, bmp, gif" />
<x-uppish::files accept="image/jpeg, image/png, image/x-ms-bmp, image/gif" />
```

#### `size`

Accepts: _(integer)_ In binary bytes<br>
Default: `config('uppish.upload_max_size')`

```php
// Accepting 10mb file in this field.
<x-uppish::files size="10485760" />
```

#### `fieldId`

Accepts: _(string)_ HTML element ID<br>
Default: `''` (empty, no ID attribute)

```php
<x-uppish::files fieldId="file" />
```

#### `fieldClass`

Accepts: _(string)_ HTML element Class<br>
Default: `''` (empty)

```php
<x-uppish::files fieldClass="file" />
```

#### `limit`

Applicable for multiple files input only (eg. `name="files[]"`)<br>
Accepts: _(integer)_ Number of files (cannot exceed `config('uppish.maximum_files')` limit)<br>
Default: `config('uppish.maximum_files')`

```php
// Accepting 5 files in this field where multiple files are accepted.
<x-uppish::files name="files[]" limit="5" />
```

#### `groupClass`

Mostly for aesthetic purposes. If you want to add more classes to the grouping element<br>
Accepts: _(string)_ Space-separated HTML classes<br>
Default: `''` (empty)

```php
<x-uppish::files groupClasses="my-class another-class" />
```

#### `btnClass`

Mostly for aesthetic purposes. If you want to add more classes to the [visible] button element<br>
Accepts: _(string)_ Space-separated HTML classes<br>
Default: `'btn btn-outline-secondary'` (Bootstrap 4 classes)

```php
<x-uppish::files btnClass="btn btn-primary my-btn-class" />
```

#### `btnText`

Mostly for aesthetic purposes. If you want to change the button text<br>
Accepts: _(string)_ Simple text or translatable string<br>
Default: `''` (Showing `Browse...`)

```php
<x-uppish::files btnClass="btn btn-primary my-btn-class" />
```

### Overriding things

#### Overriding Routes

```php
// Mark the backslash (\) before the namespace value.
Route::group(['namespace' => '\Technovistalimited\Uppish\Controllers'], function () {
    Route::group(['middleware' => ['web']], function () {
        Route::prefix('/uppish')->group(function () {
            Route::post('/upload/', 'UppishController@store')->name('uppish.upload');
            Route::post('/delete/', 'UppishController@delete')->name('uppish.delete');
            Route::post('/clear-tmp/', 'UppishController@clearTemp')->name('uppish.clear');
        });
    });
});
```

#### Overriding Uploaded Files' UI

```php

```

## Credits

* [feathericons](https://feathericons.com/)

## Wishlists

* Image Preview
* Image Gallery for multiple files
