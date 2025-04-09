@php
    $id = $getId();
    $isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $hasInlineLabel = $hasInlineLabel();
    $record = $getRecord();
    $collection = $getName();
    $name = $getName();
    $value = $record?->{$name} ?? null;
    $width = $getWidth();
    $height = $getHeight();
    $shape = $isCircular() ? 'rounded-full' : 'rounded-md';
    $image = $value ? asset($value) : $getImage();
    $isSvgCode = Str::startsWith($image, '<svg');
@endphp
<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()"
    :hint="$getHint()" :hint-actions="$getHintActions()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()" :has-inline-label="$hasInlineLabel"
    :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())->class([
        'fi-image-preview overflow-hidden',
    ])">
    <div class="flex flex-col items-center space-y-2">
        @if ($isSvgCode)
            {!! $image !!}
        @else
            <img src="{{ $image }}"
                class="object-cover shadow {{ $shape }} h-[{{ $height }}px] w-[{{ $width }}px]" />
        @endif
        <div
            {{ \Filament\Support\prepare_inherited_attributes($getAltAttributeBag())->class([
                'fi-image-preview-alt dark:text-primary',
            ]) }}>
            xxxxxxxxxxxxx
        </div>
    </div>
</x-dynamic-component>
