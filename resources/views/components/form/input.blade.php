@props([

'type' => 'text', 'value' => '', 'name', 'label' => false

])

@if($label)
	<lable class="">{{$label}}</lable>
@endif

<input style="direction: rtl;" type="{{$type}}" name="{{$name}}" value="{{old($name, $value)}}" {{$attributes->class([
    'form-control',
    'is-invalid' => $errors->has($name),
    'accept'
])}}>
@error($name)
<div class="text-danger">{{$message}}</div>
@enderror



<!-- @class([ 'form-control' , 'is-invalid'=> $errors->has($name)
]) -->
