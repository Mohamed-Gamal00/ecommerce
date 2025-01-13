@extends('dashboard.index')

@section('title', 'اضافة كود خصم')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('discount_code.index') }}">أكود الخصم</a></li>
    <li class="breadcrumb-item active">اضافة كود خصم</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('discount_code.store') }}" method="post">
                        @csrf

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم كود
                                الخصم</label>
                            <div class="col-sm-10">

                                <x-form.input type="text" name="name" placeholder=" اكتب اسم كود الخصم"/>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الكود</label>
                            <div class="col-sm-10">
                                <x-form.input type="text" name="code" placeholder=" اكتب  كود الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">نوع الخصم</label>
                            <div class="col-sm-10">

                                <div class="mb-0">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="discount_type"
                                               value="percentage" class="form-check-input">
                                        <label class="form-check-label fw-bold" for="customRadioInline1">نسبة %</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="discount_type" value="price"
                                               class="form-check-input">
                                        <label class="form-check-label fw-bold" for="customRadioInline2">سعر</label>
                                    </div>
                                </div>
                                @error('discount_type')
                                <span class="error">{{ $message }}</span>
                                @enderror

                                <x-form.input type="number" name="price" placeholder="اكتب الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">عدد مرات الاستخدام
                                المتاحه</label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="number_of_used"
                                              placeholder="اكتب عدد مرات استخدما كود الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">المنتجات</label>
                            <div class="col-sm-10">
                                <select name="product_ids[]" class="form-select product-select" aria-label="المنتجات"
                                        multiple>
                                    <option value="" disabled>اختر المنتجات (أو اتركه فارغًا لجميع المنتجات)</option>
                                </select>

                                @error('product_id')
                                <span class="error">{{ $message }}</span>
                                @enderror
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
                                    <option selected value="active">نشط</option>
                                    <option value="archived">غير نشط</option>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.product-select').select2({
                ajax: {
                    url: '{{ route('search.products') }}', // Your API endpoint
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term // Search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data // Return the results
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2, // Minimum characters to start the search
                placeholder: 'اختر المنتجات',
            });
        });
    </script>
@endsection
