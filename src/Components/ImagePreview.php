<?php

namespace Alqabali\FilamentImagePreview\Components;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasExtraAlpineAttributes;
use Illuminate\Support\HtmlString;
use Illuminate\View\ComponentAttributeBag;

class ImagePreview extends Field
{
    use HasExtraAlpineAttributes;

    protected string $view = 'backend.core.forms.components.image-preview';

    protected string | \Closure  $image;
    protected int | \Closure | null $width = 96;
    protected int | \Closure | null $height = 96;
    protected bool | \Closure $circular = false;
    protected string | int | \Closure | null $size = 'md';
    protected string | HtmlString | \Closure | null $alt = null;
    protected array | \Closure $altAttributes  = [];


    public function image(string | \Closure $image): static
    {
        $this->image = $image;
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

    public function getAltAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getAltAttributes());
    }

    public function width(int | \Closure $width): static
    {
        $this->width = $width;
        return $this;
    }

    public function height(int | \Closure $height): static
    {
        $this->height = $height;
        return $this;
    }

    public function circular(bool | \Closure $state = true): static
    {
        $this->circular = $state;
        return $this;
    }


    public function getImage(): string | \Closure
    {
        return $this->evaluate($this->image);
    }

    public function getAlt(): string | HtmlString | null
    {
        return $this->evaluate($this->alt);
    }

    public function getWidth(): int
    {
        return is_callable($this->width) ? call_user_func($this->width) : $this->width;
    }

    public function getHeight(): int
    {
        return is_callable($this->height) ? call_user_func($this->height) : $this->height;
    }

    public function isCircular(): bool
    {
        return is_callable($this->circular) ? call_user_func($this->circular) : $this->circular;
    }
}
