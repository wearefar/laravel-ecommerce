@props([
  'options' => [],
  'selected' => null,
  'required' => false,
  'disabled' => false,
])

<select {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }} {!! $attributes->merge(['class' => 'rounded-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
  <option value="" disabled selected>{{ __('Select an option') }}</option>
  @foreach ($options as $value => $label)
    <option value="{{ $value }}" {{ old($attributes->get('name'), $selected) == $value ? 'selected' : '' }} >{{ $label }}</option>
  @endforeach
</select>
