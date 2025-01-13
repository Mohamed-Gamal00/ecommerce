{{-- <div class="row mb-3 mt-5">
	<label for="example-text-input" class="col-sm-2 col-form-label fw-bold">{{$title}}</label>
	<div class="col-sm-10">
		<x-form.input id="imageUpload" type="file" name="{{$fileName}}" accept="image/*"/>
        <img src="{{$image}}" class="mt-2" id="imagePreview" class="rounded mb-5" alt="Preview" width="{{$width}}" height="{{$heigh}}">
	</div>
</div> --}}

<div class="row mb-3 mt-5">
    <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">{{ $title }}</label>
    <div class="col-sm-10">
        <x-form.input id="{{ $fileName }}Upload" type="file" name="{{ $fileName }}" accept="image/*"
            data-preview-target="{{ $fileName }}Preview" />
        <img src="{{ $image }}" class="mt-2 rounded mb-5" id="{{ $fileName }}Preview" alt="Preview"
            width="{{ $width }}" height="{{ $heigh }}" style="display: {{ $image ? 'block' : 'none' }}" />
    </div>
</div>
