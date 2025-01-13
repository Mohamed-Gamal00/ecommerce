@extends('dashboard.index')

@section('title', 'تعديل  كود خصم')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('discount_code.index')}}">أكود الخصم</a></li>
    <li class="breadcrumb-item active">تعديل كود خصم</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('discount_code.update', $discountCode->id)}}" method="post">
                        @csrf
                        @method('put')

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم كود
                                                                                                    الخصم</label>
                            <div class="col-sm-10">
                                <x-form.input :value="$discountCode->name" type="text" name="name"
                                              placeholder=" اكتب اسم كود الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الكود</label>
                            <div class="col-sm-10">
                                <x-form.input :value="$discountCode->code" type="text" name="code"
                                              placeholder=" اكتب  كود الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الخصم</label>
                            <div class="col-sm-10">
                                <x-form.input :value="$discountCode->price" type="number" name="price"
                                              placeholder="اكتب نسبة الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">عدد مرات الاستخدام المتاحه</label>
                            <div class="col-sm-10">
                                <x-form.input :value="$discountCode->number_of_used" type="number" name="number_of_used"
                                              placeholder="اكتب عدد مرات استخدما كود الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">حالة الكود</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="status" aria-label="Default select example">
                                    @error('status')
                                    <span class="error">{{ $message }}</span>
                                    @enderror
                                    <option hidden disabled>اختر حالة الكود</option>
                                    <option value="active" @selected('active' == $discountCode->status)>نشط</option>
                                    <option value="inactive" @selected('inactive' == $discountCode->status)>غير نشط
                                    </option>
                                </select>
                                @error('status')
                                <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button class="btn btn-primary mt-4" type="submit">حفظ الكود</button>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>


    {{-- Form End --}}

@endsection
