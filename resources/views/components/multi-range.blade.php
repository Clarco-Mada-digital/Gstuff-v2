<div class="flex items-center justify-center py-3">
    <div x-data="{{ 'range' . $id . '()' }}" x-init="mintrigger();
    maxtrigger()" class="relative w-full max-w-xl">
        @if ($label != '')
            <span for="{{ $id }}" class="text-center">{{ $label }}</span>
        @endif
        <div class="my-3">
            <input type="range" step="{{ $step }}" x-bind:min="min" x-bind:max="max"
                x-on:input="mintrigger" x-model="minvalue"
                class="pointer-events-none absolute z-20 h-2 w-full cursor-pointer appearance-none opacity-0">

            <input type="range" step="{{ $step }}" x-bind:min="min" x-bind:max="max"
                x-on:input="maxtrigger" x-model="maxvalue"
                class="pointer-events-none absolute z-20 h-2 w-full cursor-pointer appearance-none opacity-0">

            <div class="relative z-10 h-2">

                <div class="absolute bottom-0 left-0 right-0 top-0 z-10 rounded-md bg-gray-200"></div>

                <div class="bg-green-gs absolute bottom-0 top-0 z-20 rounded-md"
                    x-bind:style="'right:' + maxthumb + '%; left:' + minthumb + '%'"></div>

                <div class="bg-green-gs absolute left-0 top-0 z-30 -ml-1 h-4 w-4 -translate-y-[30%] rounded-full"
                    x-bind:style="'left: ' + minthumb + '%'"></div>

                <div class="bg-green-gs absolute right-0 top-0 z-30 -mr-3 h-4 w-4 -translate-y-[30%] rounded-full"
                    x-bind:style="'right: ' + maxthumb + '%'"></div>

            </div>

        </div>

        <div class="flex items-center justify-between">
            <div>
                <input type="text" maxlength="5" x-on:input="mintrigger" x-model="minvalue"
                    class="w-20 rounded border border-gray-200 px-3 py-2 text-center">
            </div>
            <div>
                <input type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxvalue"
                    class="w-20 rounded border border-gray-200 px-3 py-2 text-center">
            </div>
        </div>

    </div>

    <script>
        function {{ 'range' . $id }}() {
            return {
                minvalue: {{ $minvalue }},
                maxvalue: {{ $maxvalue }},
                min: {{ $min }},
                max: {{ $max }},
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
            }
        }
    </script>
</div>
