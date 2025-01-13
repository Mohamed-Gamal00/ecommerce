@extends('dashboard.index')

@section('title', 'تعديل اللون')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">الألوان</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('companies.edit', $color->id) }}">تعديل
            اللون</a>
    </li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('colors.update', $color->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم اللون</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="name" type="text" value="{{ $color->name }}">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror --}}
                                <x-form.input type="text" name="name" value="{{ $color->name }}" />

                            </div>
                        </div>
                        <input type="hidden" name="color_code" id="selected-color" value="{{ $color->color_code }}">

                        <div class="color" style="text-align: left;">
                            <div class="color-picker"></div>
                            <div id="color-indicator" class="color-indicator"
                                style="background-color: {{ $color->color_code }}"></div>
                            <div id="color-picker"></div>
                        </div>

                        <div style="text-align: right;">
                            <button class="btn btn-primary" type="submit">حفظ التغييرات</button>
                        </div>
                    </form>
                    {{-- Form End --}}
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>

    <script>
        let colorIndicator = document.getElementById('color-indicator');
        const colorPicker = new iro.ColorPicker("#color-picker", {
            width: 180,
            color: "{{ $color->color_code }}"
        });

        colorPicker.on('color:change', function(color) {
            colorIndicator.style.backgroundColor = color.hexString;
            document.getElementById('selected-color').value = color.hexString;
        });
    </script>

@endsection
