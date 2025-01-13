@extends('dashboard.index')

@section('title', 'اضافة لون')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('colors.index') }}">الألوان</a></li>
    <li class="breadcrumb-item active" aria-current="page">اضافة لون</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('colors.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم اللون</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="name" type="text">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror --}}
                                <x-form.input type="text" name="name" />

                            </div>
                        </div>
                        <input type="hidden" name="color_code" id="selected-color" value="#ffffff">

                        <div class="color" style="text-align: left;">
                            <div class="color-picker"></div>
                            <div id="color-indicator" class="color-indicator"></div>
                            <div id="color-picker"></div>
                            <div />
                            <div style="text-align: right;">
                                <button class="btn btn-primary" type="submit">حفظ اللون</button>

                            </div>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@jaames/iro@5"></script>

    <script>
        let colorIndicator = document.getElementById('color-indicator');
        const colorPicker = new iro.ColorPicker("#color-picker", {
            width: 180,
            color: "#fff"
        });

        colorPicker.on('color:change', function(color) {
            colorIndicator.style.backgroundColor = color.hexString;

            // Update the value of the hidden input field with the selected color
            document.getElementById('selected-color').value = color.hexString;
        });
    </script>

    {{-- Form End --}}

@endsection
