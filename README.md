# Filament ImagePreview Form Component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alqabali/filament-image-preview.svg?style=flat-square)](https://packagist.org/packages/alqabali/filament-image-preview)
[![Total Downloads](https://img.shields.io/packagist/dt/alqabali/filament-image-preview.svg?style=flat-square)](https://packagist.org/packages/alqabali/filament-image-preview)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/alqabali/filament-image-preview?style=flat-square)](https://packagist.org/packages/alqabali/filament-image-preview)
[![License](https://img.shields.io/github/license/alqabali/filament-image-preview?style=flat-square)](https://github.com/alqabali/filament-image-preview/blob/main/LICENSE.md)

<img class="filament-hidden" src="https://raw.githubusercontent.com/alqabali/filament-image-preview/master/docs/thumbnail.jpg" alt="ImagePreview component for Filament" />

`filament-image-preview` is a custom [Filament](https://filamentphp.com) form field component that provides a flexible and elegant way to preview images in your forms.

## Features
- Display a preview of an image based on a URL or fallback to a default image
- Customize width and height of the preview box
- Show images as circular or square
- Add optional `alt` text for accessibility
- Position the image container using Flexbox alignment (`start`, `center`, `end`, `between`)

---

## Installation

Install the package via Composer:

```bash
composer require alqabali/filament-image-preview
```

---

## Usage

### Basic usage
```php
use App\Backend\Modules\Core\Forms\Components\ImagePreview;

ImagePreview::make('avatar')
    ->label('User Avatar')
```

---

### Set a default image
If the value is empty, a fallback image can be provided:
```php
ImagePreview::make('avatar')
    ->defaultImage(asset('images/fallback.jpg'))
```

---

### Customize width and height
```php
ImagePreview::make('avatar')
    ->width(128)
    ->height(128)
```

---

### Make the image circular
```php
ImagePreview::make('avatar')
    ->circular(true)
```

---

### Add alt text
`alt()` accepts a string, HtmlString, or Closure:
```php
ImagePreview::make('avatar')
    ->alt('Profile picture of the user')

ImagePreview::make('avatar')
    ->alt(fn () => 'Image for ' . auth()->user()->name)
```


---

## Blade View
In your custom view (e.g. `image-preview.blade.php`):
```blade
<div {{ $attributes->merge(['class' => $getPositionClass()]) }}>
    <img
        src="{{ $getDefaultImage() }}"
        alt="{{ $getAlt() }}"
        width="{{ $getWidth() }}"
        height="{{ $getHeight() }}"
        @class([
            'rounded-full' => $isCircular(),
        ])
    />
</div>
```

---

## License
The MIT License (MIT). Please see [License File](https://github.com/alqabali/filament-image-preview/blob/main/LICENSE.md) for more information.
