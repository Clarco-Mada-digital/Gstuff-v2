@props([
    'type' => null,
    'id',
    'label' => '',
    'step' => 1,
    'minvalue' => 0,
    'maxvalue' => 100,
    'min' => 0,
    'max' => 200,
    'wireModel' => 'rangeValues',
])

<div class="flex items-center justify-center">
    <div x-data="{{ 'range' . $id }}()" x-init="mintrigger();
    maxtrigger();
    initLivewireSync()" class="relative w-full max-w-xl">

        @if ($label != '')
            <span for="{{ $id }}"
                class="font-roboto-slab text-green-gs text-center text-xs">{{ $label }}</span>
        @endif

        <div class="mx-2 my-2">
            <!-- Sliders invisibles -->
            <input type="range" step="{{ $step }}" x-bind:min="min" x-bind:max="max"
                x-on:input="mintrigger" x-model="minvalue"
                class="pointer-events-none absolute z-20 h-2 w-full cursor-pointer appearance-none opacity-0">

            <input type="range" step="{{ $step }}" x-bind:min="min" x-bind:max="max"
                x-on:input="maxtrigger" x-model="maxvalue"
                class="pointer-events-none absolute z-20 h-2 w-full cursor-pointer appearance-none opacity-0">

            <!-- Barre visuelle -->
            <div class="relative z-10 h-2">
                <div class="absolute bottom-0 left-0 right-0 top-0 z-10 rounded-md bg-gray-200"></div>

                <div class="bg-supaGirlRose absolute bottom-0 top-0 z-20 rounded-md"
                    x-bind:style="'right:' + maxthumb + '%; left:' + minthumb + '%'">
                    @if ($type == 'taille')
                        <p x-text="formatTaille(minvalue)"
                            class="font-roboto-slab text-green-gs relative z-40 mt-4 text-xs"></p>
                    @else
                        <p x-text="minvalue" class="font-roboto-slab text-green-gs relative z-40 mt-4 text-xs"></p>
                    @endif
                </div>
                <div class="bg-supaGirlRose absolute left-0 top-0 z-30 -ml-1 h-4 w-4 -translate-y-[30%] rounded-full"
                    x-bind:style="'left: ' + minthumb + '%'">

                </div>
                <div class="bg-supaGirlRose absolute right-0 top-0 z-30 -mr-3 h-4 w-4 -translate-y-[30%] rounded-full"
                    x-bind:style="'right: ' + maxthumb + '%'">
                    @if ($type == 'taille')
                        <p x-text="formatTaille(maxvalue)"
                            class="font-roboto-slab text-green-gs relative right-5 z-40 mt-4 text-xs"></p>
                    @else
                        <p x-text="maxvalue" class="font-roboto-slab text-green-gs relative right-2 z-40 mt-4 text-xs">
                        </p>
                    @endif
                </div>
            </div>
        </div>


    </div>

    <!-- Alpine.js script -->
    <script>
        function {{ 'range' . $id }}() {
            return {
                minvalue: {{ (int) $minvalue }},
                maxvalue: {{ (int) $maxvalue }},
                min: {{ (int) $min }},
                max: {{ (int) $max }},
                minthumb: 0,
                maxthumb: 0,

                mintrigger() {
                    this.minvalue = Math.min(this.minvalue, this.maxvalue - 2);
                    this.minthumb = ((this.minvalue - this.min) / (this.max - this.min)) * 100;
                },

                maxtrigger() {
                    this.maxvalue = Math.max(this.maxvalue, this.minvalue + 2);
                    this.maxthumb = 100 - (((this.maxvalue - this.min) / (this.max - this.min)) * 100);
                },

                formatTaille(val) {
                    val = parseInt(val);
                    if (val >= 100) {
                        let metres = Math.floor(val / 100);
                        let centimetres = val % 100;
                        return `${metres}m${centimetres}`;
                    } else {
                        return (val / 100).toFixed(2) + 'm';
                    }
                },

                initLivewireSync() {
                    this.$watch('minvalue', value => {
                        this.$wire.set('{{ $wireModel }}', {
                            min: value,
                            max: this.maxvalue
                        });
                    });
                    this.$watch('maxvalue', value => {
                        this.$wire.set('{{ $wireModel }}', {
                            min: this.minvalue,
                            max: value
                        });
                    });
                }
            }
        }
    </script>
</div>
