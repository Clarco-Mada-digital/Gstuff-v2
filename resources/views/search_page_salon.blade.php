@extends('layouts.base')

  @section('extraStyle')
  <style>
    .range-slider, .multi-range-slider {
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      position: relative;
      margin-top: 2.5rem;
      margin-bottom: 2rem;
    }

    .multi-range-slider .range-slider {
      margin: 0;
    }

    .range {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      width: 100%;
    }

    .range:focus {
      outline: 0;
    }

    .range-slider::before, .range-slider::after,
    .multi-range-slider::before, .multi-range-slider::after {
      position: absolute;
      font-size: 0.875rem;
      line-height: 1;
      padding: 0.25rem;
      border-radius: 0.25rem;
      background-color: #d2d6dc;
      color: #4b5563;
      top: -2rem;
      z-index: 5;
    }

    .multi-range-slider .range-slider::before, .multi-range-slider .range-slider::after {
      content: none !important;
    }

    .range-slider::before, .multi-range-slider::before {
      left: 0;
      content: attr(data-min);
    }

    .range-slider::after, .multi-range-slider::after {
      right: 0;
      content: attr(data-max);
    }

    .range::-webkit-slider-runnable-track {
      width: 100%;
      height: 1rem;
      cursor: pointer;
      border-radius: 9999px;
      background-color: #cfd8e3;
      animate: 0.2s;
    }

    .range::-webkit-slider-thumb {
      z-index: 10;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      position: relative;
      -webkit-appearance: none;
      appearance: none;
      cursor: pointer;
      border-radius: 9999px;
      background-color: #ffffff;
      height: 1rem;
      width: 1rem;
      border-width: 1px;
      border-style: solid;
      border-color: green;
      transform: translateY(calc(-50% + 0.5rem));
    }

    .tooltip {
      position: absolute;
      display: block;
      text-align: center;
      color: #ffffff;
      line-height: 1;
      padding-left: 0.25rem;
      padding-right: 0.25rem;
      padding-top: 0.125rem;
      padding-bottom: 0.125rem;
      border-radius: 0.125rem;
      font-size: 1rem;
      --transform-translate-x: 0;
      --transform-translate-y: 0;
      --transform-rotate: 0;
      --transform-skew-x: 0;
      --transform-skew-y: 0;
      --transform-scale-x: 1;
      --transform-scale-y: 1;
      transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
      --transform-translate-x: -50%;
      left: 50%;
      top: -2rem;
      background: green;
      z-index: 12;
    }

    .tooltip:before {
      position: absolute;
      --transform-translate-x: 0;
      --transform-translate-y: 0;
      --transform-rotate: 0;
      --transform-skew-x: 0;
      --transform-skew-y: 0;
      --transform-scale-x: 1;
      --transform-scale-y: 1;
      transform: translateX(var(--transform-translate-x)) translateY(var(--transform-translate-y)) rotate(var(--transform-rotate)) skewX(var(--transform-skew-x)) skewY(var(--transform-skew-y)) scaleX(var(--transform-scale-x)) scaleY(var(--transform-scale-y));
      --transform-translate-x: -50%;
      left: 50%;
      bottom: -0.5rem;
      width: 0;
      height: 0;
      border-width: 4px;
      border-style: solid;
      border-color: transparent;
      content: "";
      border-top-color: green;
    }

    .multi-range-slider .range-slider {
      position: absolute;
    }
  </style>
  @endsection

  @section('pageTitle')
    Salon
  @endsection

  @section('content')

    @livewire('salon-search')    

    <x-feedback-section />

    <x-call-to-action-inscription />

    
  @endsection

  @section('extraScripts')

  @endsection
