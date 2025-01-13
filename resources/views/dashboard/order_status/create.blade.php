@extends('dashboard.index')

@section('title', 'اضافة حالة طلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('order_status.index')}}">حالات التوفر</a></li>
    <li class="breadcrumb-item active">اضافة حالة طلب</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('order_status.store')}}" method="post">
                        @csrf

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم حالة
                                                                                                    الطلب</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name" placeholder=" اكتب اسم حالة الطلب"/>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">حالة لطلب بالانجليزي</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="name_en" value="{{old('name_en')}}"  placeholder=" اكتب اسم حالة الطلب"/>
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
