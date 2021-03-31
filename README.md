# Uppish

## Start development

### Step 1: Put the package in place

Get to your project root, and run the following command:

```shell
git clone git@gitlab.com:technovistaltd/tvl/uppish.git packages/technovistalimited/uppish/
```

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

```php
@push('styles')
    /* <link rel="stylesheet" href="path/to/bootstrap-4.min.css"> */
    <link rel="stylesheet" href="{{ asset('vendor/uppish/css/uppish.css') }}">
    /* <link rel="stylesheet" href="{{ asset('vendor/uppish/css/interface.css') }}"> */
@endpush
```

```php
@push('scripts')
    @include('vendor.uppish.php-js')

    <!-- <script src="path/to/jquery-3.6.min.js"></script> -->
    <script src="{{ asset('vendor/uppish/js/uppish.js') }}"></script>
@endpush
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

## Credits

* [feathericons](https://feathericons.com/)

## Wishlists

* Image Preview
* Image Gallery for multiple files
