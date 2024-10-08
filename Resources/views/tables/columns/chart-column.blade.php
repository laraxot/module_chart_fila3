@php
    //$color = $obj->getColor();
    //$heading = $obj->getHeading();
    //$description = $obj->getDescription();
    //$filters = $obj->getFilters();
    $color='red';
    // $heading='heading';
    // $description = 'description';
@endphp


    <x-filament::section
        {{-- :description="$description"
        :heading="$heading" --}}
        class="fi-wi-chart w-full"
    >
    {{--
    @if ($filters)
            <x-slot name="headerEnd">
                <x-filament::input.wrapper
                    inline-prefix
                    wire:target="filter"
                    class="-my-2"
                >
                    <x-filament::input.select
                        inline-prefix
                        wire:model.live="filter"
                    >
                        @foreach ($filters as $value => $label)
                            <option value="{{ $value }}">
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </x-slot>
        @endif
            --}}
        <div
            {{--
            @if ($pollingInterval = $obj->getPollingInterval())
                wire:poll.{{ $pollingInterval }}="updateChartData"
            @endif
            --}}
        >
            <div
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('chart', 'filament/widgets') }}"
                wire:ignore
                x-data="chart({
                            cachedData: @js($obj->getCachedData()),
                            options: @js($obj->getOptions()),
                            type: @js($obj->getType()),
                        })"
                x-ignore
                @style([
                    \Filament\Support\get_color_css_variables($color, shades: [50, 400, 500]) => $color !== 'gray',
                ])
            >
                <canvas
                    x-ref="canvas"
                    @if ($maxHeight = $obj->getMaxHeight())
                        style="max-height: {{ $maxHeight }}"
                    @endif
                ></canvas>

                <span
                    x-ref="backgroundColorElement"
                    @class([
                        match ($color) {
                            'gray' => 'text-gray-100 dark:text-gray-800',
                            default => 'text-custom-50 dark:text-custom-400/10',
                        },
                    ])
                ></span>

                <span
                    x-ref="borderColorElement"
                    @class([
                        match ($color) {
                            'gray' => 'text-gray-400',
                            default => 'text-custom-500 dark:text-custom-400',
                        },
                    ])
                ></span>

                <span
                    x-ref="gridColorElement"
                    class="text-gray-200 dark:text-gray-800"
                ></span>

                <span
                    x-ref="textColorElement"
                    class="text-gray-500 dark:text-gray-400"
                ></span>
            </div>
        </div>
    </x-filament::section>

