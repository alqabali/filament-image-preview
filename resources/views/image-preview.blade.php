@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $hasInlineLabel = $hasInlineLabel();
    $name = $getName();
    $value = $getState() ?? null;

    // مصدر الصورة
    $rawImage = $value ?? $getImage();

    $image = $rawImage ? $getImageUrl($rawImage) : $getDefaultImageUrl();

    $width = $getWidth();
    $height = $getHeight();
    $shape = $isCircular() ? 'rounded-full' : ($isSquare() ? 'rounded-none' : 'rounded-md');

    $isSvgCode = is_string($image) && Str::startsWith($image, '<svg');

    $altText = $getAlt();
    $altClass = $getAltAttributeBag()->get('class') ?? '';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :id="$id" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-actions="$getHintActions()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$statePath" :has-inline-label="$hasInlineLabel"
    :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())->class([
        'fi-image-preview overflow-hidden',
    ])">
    <div class="flex flex-col items-center space-y-0">
        @if ($isSvgCode)
            {!! $image !!}
        @elseif ($image)
            <img src="{{ $image }}" alt="{{ $altText }}" class="object-cover shadow {{ $shape }}"
                style="width: {{ $width }}; height: {{ $height }};" />
        @endif

        @if ($altText)
            <div class="fi-image-preview-alt {{ $altClass }}">
                {{ $altText }}
            </div>
        @endif
    </div>
</x-dynamic-component>
