<?php

namespace Alqabali\FilamentImagePreview\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\ComponentAttributeBag;
use League\Flysystem\UnableToCheckFileExistence;
use Throwable;

class ImagePreview extends Field
{
    use HasExtraAlpineAttributes;

    protected string $view = 'filament-image-preview::image-preview';

    protected string | \Closure | null $image = null;
    protected int | string | \Closure | null $width = 'auto';
    protected int | string | \Closure | null $height = 'auto';
    protected string | int | \Closure | null $size = 'auto';
    protected string | HtmlString | \Closure | null $alt = null;
    protected bool | Closure $circular = false;
    protected bool | Closure $square = false;
    protected string | Closure $visibility = 'public';
    protected string | Closure | null $defaultImageUrl = null;
    protected bool | Closure $shouldCheckFileExistence = true;
    protected string | Closure | null $disk = null;
    protected array | \Closure $altAttributes = [
        ['class' => 'fi-image-preview-alt text-gray-500 dark:text-gray-400'],
    ];


    public function image(string | \Closure $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function defaultImageUrl(string | Closure | null $url): static
    {
        $this->defaultImageUrl = $url;

        return $this;
    }

    public function alt(string | HtmlString | \Closure | null $alt): static
    {
        $this->alt = $alt;
        return $this;
    }
    /**
     * @var array<array<mixed> | Closure>
     */
    protected array $extraAttributes = [];

    /**
     * @param  array<mixed> | Closure  $attributes
     */
    public function altAttributes(array | Closure $attributes = [], bool $merge = false): static
    {
        if ($merge) {
            $this->altAttributes[] = $attributes;
        } else {
            $this->altAttributes = [$attributes];
        }

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getAltAttributes(): array
    {
        $temporaryAttributeBag = new ComponentAttributeBag;

        foreach ($this->altAttributes as $altAttributes) {
            $temporaryAttributeBag = $temporaryAttributeBag->merge($this->evaluate($altAttributes));
        }

        return $temporaryAttributeBag->getAttributes();
    }

    public function size(int | string | Closure $size): static
    {
        $this->width($size);
        $this->height($size);

        return $this;
    }

    public function getAltAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getAltAttributes());
    }

    public function height(int | string | \Closure $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function circular(bool | \Closure $state = true): static
    {
        $this->circular = $state;
        return $this;
    }

    public function square(bool | Closure $condition = true): static
    {
        $this->square = $condition;

        return $this;
    }


    public function getImage(): string | \Closure | null
    {
        return $this->evaluate($this->image);
    }

    public function getAlt(): string | HtmlString | null
    {
        return $this->evaluate($this->alt);
    }


    public function getHeight(): ?string
    {
        $height = $this->evaluate($this->height);

        if ($height === null) {
            return null;
        }

        if (is_int($height)) {
            return "{$height}px";
        }

        return $height;
    }

    public function getImageUrl(?string $state = null): ?string
    {
        if ((filter_var($state, FILTER_VALIDATE_URL) !== false) || str($state)->startsWith('data:')) {
            return $state;
        }

        /** @var FilesystemAdapter $storage */
        $storage = $this->getDisk();

        if ($this->shouldCheckFileExistence() && $state !== null) {
            try {
                if (! $storage->exists($state)) {
                    return null;
                }
            } catch (UnableToCheckFileExistence $exception) {
                return null;
            }
        }

        if ($this->getVisibility() === 'private') {
            try {
                return $storage->temporaryUrl(
                    $state,
                    now()->addMinutes(5),
                );
            } catch (Throwable $exception) {
                // This driver does not support creating temporary URLs.
            }
        }

        return $storage->url($state);
    }

    public function getVisibility(): string
    {
        return $this->evaluate($this->visibility);
    }

    public function visibility(string | Closure $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getDefaultImageUrl(): ?string
    {
        return $this->evaluate($this->defaultImageUrl);
    }

    public function disk(string | Closure | null $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function getDiskName(): string
    {
        return $this->evaluate($this->disk) ?? config('filament.default_filesystem_disk');
    }

    public function getWidth(): ?string
    {
        $width = $this->evaluate($this->width);

        if ($width === null) {
            return null;
        }

        if (is_int($width)) {
            return "{$width}px";
        }

        return $width;
    }

    public function width(int | string | Closure | null $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getDisk(): Filesystem
    {
        return Storage::disk($this->getDiskName());
    }

    public function isCircular(): bool
    {
        return (bool) $this->evaluate($this->circular);
    }

    public function isSquare(): bool
    {
        return (bool) $this->evaluate($this->square);
    }

    public function checkFileExistence(bool | Closure $condition = true): static
    {
        $this->shouldCheckFileExistence = $condition;

        return $this;
    }

    public function shouldCheckFileExistence(): bool
    {
        return (bool) $this->evaluate($this->shouldCheckFileExistence);
    }
}
