<?php

namespace Alqabali\FilamentImagePreview;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentImagePreviewServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-image-preview')->hasViews();
    }
    public function packageBooted(): void
    {

        FilamentAsset::register(
            assets: [
                Css::make('filament-image-preview', __DIR__ . '/../resources/dist/style.css'),
            ],
            package: 'alqabali/filament-image-preview'
        );
    }
}
