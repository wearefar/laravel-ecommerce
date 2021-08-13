@props(['required' => false, 'disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {!! $attributes->merge(['class' => 'rounded-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
