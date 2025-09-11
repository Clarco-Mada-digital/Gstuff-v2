@php
    $modelName = $attributes->wire('model')->value();
    $minValue = $attributes->get('min', 0);
    $maxValue = $attributes->get('max', 100);
@endphp

<div class="middle"
    >
    
</div>

<style>
    /* (Même CSS que précédemment) */
    .middle {
        position: relative;
        width: 100%;
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
   
</script>
