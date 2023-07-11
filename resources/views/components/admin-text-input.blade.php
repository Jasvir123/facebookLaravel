@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500']) !!}>