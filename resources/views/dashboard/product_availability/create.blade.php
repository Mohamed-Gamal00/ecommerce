@extends('dashboard.index')

@section('title', 'اضافة حالة توفر')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('product_availability.index') }}">حالات التوفر</a></li>
    <li class="breadcrumb-item active">اضافة حالة توفر</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('product_availability.store') }}" method="post">
                        @csrf

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم حالة
                                التوفر</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name" placeholder=" اكتب اسم حالة التوفر" />
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم الحالة
                                بالانجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" value="{{old('name_en') }}" name="name_en"
                                    placeholder=" اكتب اسم حالة باللغة الانجليزية" />
                            </div>
                        </div>

                        <button class="btn btn-primary mt-4" type="submit">حفظ الحالة</button>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
