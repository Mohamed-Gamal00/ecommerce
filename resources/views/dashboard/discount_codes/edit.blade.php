@extends('dashboard.index')

@section('title', 'تعديل كود خصم')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('discount_code.index') }}">أكود الخصم</a></li>
    <li class="breadcrumb-item active">تعديل كود خصم</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('discount_code.update', $discountCode->id) }}" method="post">
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

                                <div class="mb-0">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline1" name="discount_type"
                                               value="percentage"
                                               {{ $discountCode->discount_type == 'percentage' ? 'checked' : '' }}
                                               class="form-check-input">
                                        <label class="form-check-label fw-bold" for="customRadioInline1">نسبة %</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="customRadioInline2" name="discount_type" value="price"
                                               {{ $discountCode->discount_type == 'price' ? 'checked' : '' }}
                                               class="form-check-input">
                                        <label class="form-check-label fw-bold" for="customRadioInline2">سعر</label>
                                    </div>
                                </div>
                                @error('discount_type')
                                <span class="error">{{ $message }}</span>
                                @enderror

                                <x-form.input :value="$discountCode->price" type="number" name="price"
                                              placeholder="اكتب الخصم"/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">عدد مرات الاستخدام
                                المتاحه</label>
                            <div class="col-sm-10">
                                <x-form.input :value="$discountCode->number_of_used" type="number" name="number_of_used"
                                              placeholder="اكتب عدد مرات استخدما كود الخصم"/>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label fw-bold">المنتجات</label>
                            <div class="col-sm-10">
                                <select name="product_ids[]" class="form-select product-select" aria-label="المنتجات"
                                        multiple>
                                    <option value="" disabled>اختر المنتجات (أو اتركه فارغًا لجميع المنتجات)</option>

                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                                {{ in_array($product->id, $discountProductsIds) ? 'selected' : '' }}>
                                            {{ $product->CurrentNameLang }}
                                        </option>
                                    @endforeach
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
                minimumInputLength: 1, // Minimum characters to start the search
                placeholder: 'اختر المنتجات',
            });
        });
    </script>

@endsection
