@extends('dashboard.index')

@section('title', 'اضافة شركة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">الشركات</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('companies.create') }}">اضافة شركة</a></li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الشركة</label>
                            <div class="col-sm-10">
                                {{-- <input class="form-control" name="name" type="text">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror --}}
                                <x-form.input type="text" name="name" />

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">اسم الشركة بالانجليزي</label>
                            <div class="col-sm-10">

                                <x-form.input type="text" name="name_en" value="{{old('name_en')}}" />

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
                        <button class="btn btn-primary" type="submit">حفظ الشركه</button>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
