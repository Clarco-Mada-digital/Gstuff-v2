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
<div class="flex items-center justify-center my-2">
    <div
        x-data="rangeController(
            {{ (int) $minvalue }},
            {{ (int) $maxvalue }},
            {{ (int) $min }},
            {{ (int) $max }},
            '{{ $wireModel }}',
            '{{ $id }}'
        )"
        x-init="init()"
        x-ref="sliderContainer"
        class="relative w-full max-w-xl"
    >
        @if ($label != '')
            <span class="font-roboto-slab text-green-gs text-center text-xs">{{ $label }}</span>
        @endif
        <!-- Boutons de test pour le debug -->
        <div class="flex">
            <button @click="decrementMin" class="bg-blue-500 text-white p-1 rounded text-xs hidden">- Min</button>
            <button @click="incrementMin" class="bg-blue-500 text-white p-1 rounded text-xs hidden">+ Min</button>
            <button @click="decrementMax" class="bg-red-500 text-white p-1 rounded text-xs hidden">- Max</button>
            <button @click="incrementMax" class="bg-red-500 text-white p-1 rounded text-xs hidden">+ Max</button>
        </div>
        <div class="mx-2 my-2">
            <!-- Sliders invisibles -->
            <input
                type="range"
                step="{{ $step }}"
                x-bind:min="min"
                x-bind:max="max"
                x-on:input="updateMin"
                x-model="minvalue"
                class="absolute z-30 h-2 w-full  appearance-none opacity-0"
                style="pointer-events: none;" 
            >
            <input
                type="range"
                step="{{ $step }}"
                x-bind:min="min"
                x-bind:max="max"
                x-on:input="updateMax"
                x-model="maxvalue"
                class="absolute z-20 h-2 w-full  appearance-none opacity-0"
                style="pointer-events: none;" 
                
            >
            <!-- Barre visuelle (non cliquable) -->
            <div
                x-ref="track"
                class="relative z-10 h-2"
                @mousedown.prevent
                @touchstart.prevent
            >
                <div class="absolute bottom-0 left-0 right-0 top-0 z-10 rounded-md bg-gray-200"></div>
                <div
                    class="bg-supaGirlRose absolute bottom-0 top-0 z-20 rounded-md"
                    x-bind:style="'right:' + maxthumb + '%; left:' + minthumb + '%'"
                >
                   
                </div>
                <!-- Curseurs (seuls éléments interactifs) -->
                <div
                    id="min-thumb-{{ $id }}"
                    class="bg-supaGirlRose absolute left-0 top-0 z-40 -ml-1 h-4 w-4 -translate-y-[30%] rounded-full cursor-pointer"
                    x-bind:style="'left: ' + minthumb + '%'"
                    @mousedown="minThumbActive = true"
                    @mouseup="minThumbActive = false"
                    @touchstart="minThumbActive = true"
                    @touchend="minThumbActive = false"
                    

                     @mouseenter="$el.classList.add('thumb-hover-min')"
                     @mouseleave="$el.classList.remove('thumb-hover-min')"
                >
                @if ($type == 'taille')
                        <p x-text="formatTaille(minvalue)" class="font-roboto-slab text-green-gs relative z-40 mt-4 text-xs"></p>
                    @else
                        <p x-text="minvalue" class="font-roboto-slab text-green-gs relative z-40 mt-4 text-xs"></p>
                    @endif
            
            
            </div>
                <div
                    id="max-thumb-{{ $id }}"
                    class="bg-supaGirlRose absolute right-0 top-0 z-35 -mr-3 h-4 w-4 -translate-y-[30%] rounded-full cursor-pointer"
                    x-bind:style="'right: ' + maxthumb + '%'"
                    @mousedown="maxThumbActive = true"
                    @mouseup="maxThumbActive = false"
                    @touchstart="maxThumbActive = true"
                    @touchend="maxThumbActive = false"

                        @mouseenter="$el.classList.add('thumb-hover-max')"
                        @mouseleave="$el.classList.remove('thumb-hover-max')"
                >
                    @if ($type == 'taille')
                        <p x-text="formatTaille(maxvalue)" class="font-roboto-slab text-green-gs relative right-5 z-40 mt-4 text-xs"></p>
                    @else
                        <p x-text="maxvalue + '+'" class="font-roboto-slab text-green-gs relative right-2 z-40 mt-4 text-xs"></p>
                    @endif
                
                </div>
            </div>
        </div>
    </div>

    <style>
   
    .thumb-hover-min {
        background-color:#7F55B1; 
        
    }
    .thumb-hover-max {
        background-color:#7F55B1;
    }
</style>

</div>

<script>
    function rangeController(minvalue, maxvalue, min, max, wireModel, id) {
        return {
            minThumbActive: false,
            maxThumbActive: false,
            minvalue: minvalue,
            maxvalue: maxvalue,
            min: min,
            max: max,
            minthumb: 0,
            maxthumb: 0,
            draggingMin: false,
            draggingMax: false,
            init() {
                this.$refs = {};
                this.$refs.track = this.$el.querySelector('[x-ref="track"]');
                this.updateMin();
                this.updateMax();
                this.initLivewireSync();
                this.attachDragListeners();
            },
            attachDragListeners() {
                const minThumb = document.getElementById(`min-thumb-${id}`);
                const maxThumb = document.getElementById(`max-thumb-${id}`);
                minThumb.addEventListener('mousedown', (e) => this.startDragMin(e));
                minThumb.addEventListener('touchstart', (e) => this.startDragMin(e));
                maxThumb.addEventListener('mousedown', (e) => this.startDragMax(e));
                maxThumb.addEventListener('touchstart', (e) => this.startDragMax(e));
            },
            updateMin() {
                this.minvalue = Math.min(this.minvalue, this.maxvalue - 2);
                this.minthumb = ((this.minvalue - this.min) / (this.max - this.min)) * 100;
            },
            updateMax() {
                this.maxvalue = Math.max(this.maxvalue, this.minvalue + 2);
                this.maxthumb = 100 - (((this.maxvalue - this.min) / (this.max - this.min)) * 100);
            },
            decrementMin() {
                this.minvalue = Math.max(this.min, this.minvalue - 1);
                this.updateMin();
            },
            incrementMin() {
                this.minvalue = Math.min(this.maxvalue - 2, this.minvalue + 1);
                this.updateMin();
            },
            decrementMax() {
                this.maxvalue = Math.max(this.minvalue + 2, this.maxvalue - 1);
                this.updateMax();
            },
            incrementMax() {
                this.maxvalue = Math.min(this.max, this.maxvalue + 1);
                this.updateMax();
            },
            startDragMin(e) {
                e.preventDefault();
                e.stopPropagation();
                this.draggingMin = true;
                document.addEventListener('mousemove', this.dragMin.bind(this));
                document.addEventListener('mouseup', this.stopDragMin.bind(this));
                document.addEventListener('touchmove', this.dragMin.bind(this));
                document.addEventListener('touchend', this.stopDragMin.bind(this));
            },
            dragMin(e) {
                if (!this.draggingMin) return;
                e.preventDefault();
                const track = this.$refs.track;
                const rect = track.getBoundingClientRect();
                const x = (e.clientX || e.touches[0].clientX) - rect.left;
                const percentage = Math.max(0, Math.min(100, (x / rect.width) * 100));
                this.minthumb = percentage;
                this.minvalue = this.min + Math.round((percentage / 100) * (this.max - this.min));
                this.minvalue = Math.min(this.minvalue, this.maxvalue - 1);
                this.updateMin();
            },
            stopDragMin(e) {
                e.preventDefault();
                this.draggingMin = false;
                document.removeEventListener('mousemove', this.dragMin);
                document.removeEventListener('mouseup', this.stopDragMin);
                document.removeEventListener('touchmove', this.dragMin);
                document.removeEventListener('touchend', this.stopDragMin);
            },
            startDragMax(e) {
                e.preventDefault();
                e.stopPropagation();
                this.draggingMax = true;
                document.addEventListener('mousemove', this.dragMax.bind(this));
                document.addEventListener('mouseup', this.stopDragMax.bind(this));
                document.addEventListener('touchmove', this.dragMax.bind(this));
                document.addEventListener('touchend', this.stopDragMax.bind(this));
            },
            dragMax(e) {
                if (!this.draggingMax) return;
                e.preventDefault();
                const track = this.$refs.track;
                const rect = track.getBoundingClientRect();
                const x = (e.clientX || e.touches[0].clientX) - rect.left;
                const percentage = Math.max(0, Math.min(100, (x / rect.width) * 100));
                this.maxthumb = 100 - percentage;
                this.maxvalue = this.min + Math.round(((100 - this.maxthumb) / 100) * (this.max - this.min));
                this.maxvalue = Math.max(this.maxvalue, this.minvalue + 2);
                this.updateMax();
            },
            stopDragMax(e) {
                e.preventDefault();
                this.draggingMax = false;
                document.removeEventListener('mousemove', this.dragMax);
                document.removeEventListener('mouseup', this.stopDragMax);
                document.removeEventListener('touchmove', this.dragMax);
                document.removeEventListener('touchend', this.stopDragMax);
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
                    this.$wire.set(wireModel, { min: value, max: this.maxvalue });
                });
                this.$watch('maxvalue', value => {
                    this.$wire.set(wireModel, { min: this.minvalue, max: value });
                });
            }
        };
    }
</script>
