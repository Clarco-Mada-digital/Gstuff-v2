<div class="middle" x-data="{ minValue: {{ $leftValue ?? 25 }}, maxValue: {{ $rightValue ?? 75 }} }"
     x-init="
         document.getElementById('min-value').textContent = 'Min: ' + minValue;
         document.getElementById('max-value').textContent = 'Max: ' + maxValue;
         $watch('minValue', value => document.getElementById('min-value').textContent = 'Min: ' + value);
         $watch('maxValue', value => document.getElementById('max-value').textContent = 'Max: ' + value);
     ">
    <div class="multi-range-slider">
        <input type="range" id="input-left" min="{{ $min ?? 0 }}" max="{{ $max ?? 100 }}" x-model="minValue"
               @input="
                   if (parseInt($event.target.value) >= parseInt(document.getElementById('input-right').value)) {
                       minValue = parseInt(document.getElementById('input-right').value) - 1;
                   }
                   $dispatch('range-update', { min: minValue, max: maxValue });
               ">
        <input type="range" id="input-right" min="{{ $min ?? 0 }}" max="{{ $max ?? 100 }}" x-model="maxValue"
               @input="
                   if (parseInt($event.target.value) <= parseInt(document.getElementById('input-left').value)) {
                       maxValue = parseInt(document.getElementById('input-left').value) + 1;
                   }
                   $dispatch('range-update', { min: minValue, max: maxValue });
               ">
        <div class="slider">
            <div class="track"></div>
            <div class="range" x-bind:style="`left: ${(minValue - {{ $min ?? 0 }}) / ({{ $max ?? 100 }} - {{ $min ?? 0 }}) * 100}%; right: ${100 - (maxValue - {{ $min ?? 0 }}) / ({{ $max ?? 100 }} - {{ $min ?? 0 }}) * 100}%`"></div>
            <div class="thumb left" x-bind:style="`left: ${(minValue - {{ $min ?? 0 }}) / ({{ $max ?? 100 }} - {{ $min ?? 0 }}) * 100}%`"></div>
            <div class="thumb right" x-bind:style="`left: ${(maxValue - {{ $min ?? 0 }}) / ({{ $max ?? 100 }} - {{ $min ?? 0 }}) * 100}%`"></div>
        </div>
    </div>
    <div class="values-display">
        <span id="min-value">Min: {{ $leftValue ?? 25 }}</span>
        <span id="max-value">Max: {{ $rightValue ?? 75 }}</span>
    </div>
</div>

<style>
    .middle {
        position: relative;
        width: 50%;
        max-width: 500px;
    }
    .multi-range-slider {
        position: relative;
    }
    .slider {
        position: relative;
        z-index: 1;
        height: 10px;
        margin: 0 15px;
    }
    .slider > .track {
        position: absolute;
        z-index: 1;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        border-radius: 5px;
        background-color: #c6aee7;
    }
    .slider > .range {
        position: absolute;
        z-index: 2;
        top: 0;
        bottom: 0;
        border-radius: 5px;
        background-color: #6200ee;
    }
    .slider > .thumb {
        position: absolute;
        z-index: 3;
        width: 30px;
        height: 30px;
        background-color: #6200ee;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(98,0,238,.1);
        transition: box-shadow .3s ease-in-out;
        top: -10px;
        margin-left: -15px;
    }
    .slider > .thumb.hover {
        box-shadow: 0 0 0 20px rgba(98,0,238,.1);
    }
    .slider > .thumb.active {
        box-shadow: 0 0 0 40px rgba(98,0,238,.2);
    }
    input[type=range] {
        position: absolute;
        pointer-events: none;
        -webkit-appearance: none;
        z-index: 2;
        height: 10px;
        width: 100%;
        opacity: 0;
    }
    input[type=range]::-webkit-slider-thumb {
        pointer-events: all;
        width: 30px;
        height: 30px;
        border-radius: 0;
        border: 0 none;
        background-color: red;
        -webkit-appearance: none;
    }
    .values-display {
        display: flex;
        justify-content: space-between;
        margin: 20px 15px 0 15px;
        font-weight: bold;
        color: #333;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputLeft = document.getElementById("input-left");
        const inputRight = document.getElementById("input-right");
        const thumbLeft = document.querySelector(".slider > .thumb.left");
        const thumbRight = document.querySelector(".slider > .thumb.right");

        inputLeft.addEventListener("mouseover", () => thumbLeft.classList.add("hover"));
        inputLeft.addEventListener("mouseout", () => thumbLeft.classList.remove("hover"));
        inputLeft.addEventListener("mousedown", () => thumbLeft.classList.add("active"));
        inputLeft.addEventListener("mouseup", () => thumbLeft.classList.remove("active"));

        inputRight.addEventListener("mouseover", () => thumbRight.classList.add("hover"));
        inputRight.addEventListener("mouseout", () => thumbRight.classList.remove("hover"));
        inputRight.addEventListener("mousedown", () => thumbRight.classList.add("active"));
        inputRight.addEventListener("mouseup", () => thumbRight.classList.remove("active"));
    });
</script>
