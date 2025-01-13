@extends('dashboard.index')

@section('title', 'اضافة ميزة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('store_featuers.index') }}">المميزات</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('companies.create') }}">اضافة ميزة</a></li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('store_featuers.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الميزة</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="name" type="text">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror --}}
                                <x-form.input type="text" value="{{ old('title') }}" name="title" />

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الميزة بالنجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="title_en" value="{{old('title_en')}}" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-number-input" class="col-sm-2 col-form-label fw-bold">الوصف</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="7" name="description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الصورة</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-select" name="image" accept="image/*">
                                @error('image')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">حفظ الميزة</button>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
