@extends('dashboard.index')

@section('title', 'اضافة حالة الطلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('product_availability.index') }}">حالات الطلب</a></li>
    <li class="breadcrumb-item active">تعديل حالة الطلب</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('order_status.update', $orderStatus->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم حالة
                                الطلب</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" value="{{ $orderStatus->name }}" name="name"
                                    placeholder=" اكتب اسم حالة الطلب" />
                            </div>
                        </div>


                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">حالة الطلب
                                بالانجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name_en" value="{{ $orderStatus->name_en }}"
                                    placeholder="  حالة الطلب بالانجليزية" />
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
