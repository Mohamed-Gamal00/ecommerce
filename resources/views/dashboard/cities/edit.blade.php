@extends('dashboard.index')

@section('title', 'تعديل مدينة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('cities.index') }}">المدن</a></li>
    <li class="breadcrumb-item">تعديل مدينة</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('cities.update', $city->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="col-sm-10">
                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم الدولة</label>
                                <div class="col-sm-10">
                                    <select name="country_id" id="country" class="form-select">
                                        <option value="" hidden>الدولة</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ $city->country_id == $country->id ? 'selected' : '' }}>
                                                {{ $country->name_ar }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم المدينة
                                    بالعربي</label>
                                <div class="col-sm-10">
                                    <x-form.input type="text" name="name_ar"
                                        value="{{ old('name_ar', $city->name_ar) }}" />
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">اسم المدينة
                                    بالانجليزي</label>
                                <div class="col-sm-10">
                                    <x-form.input type="text" name="name_en"
                                        value="{{ old('name_en', $city->name_en) }}" />
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">كود المدينة</label>
                                <div class="col-sm-10">
                                    <x-form.input type="number" name="code" value="{{ old('code', $city->code) }}" />
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">الحالة</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option hidden disabled>اختر حالة المنتج</option>
                                        <option value="used" {{ $city->status == 'used' ? 'selected' : '' }}>نشط</option>
                                        <option value="not_used" {{ $city->status == 'not_used' ? 'selected' : '' }}>غير نشط
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label fw-bold">سعر الشحن</label>
                                <div class="col-sm-10">
                                    <x-form.input type="number" name="shipping_price"
                                        value="{{ old('shipping_price', $city->shipping_price) }}" />
                                </div>
                            </div>
                            @error('country_id')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">حفظ</button>
                        </div>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('country').addEventListener('change', function () {
            var selectedCountryId = this.value;
            var cityCheckboxes = document.querySelectorAll('.city-checkbox');

            cityCheckboxes.forEach(function (checkbox) {
                var countryId = checkbox.getAttribute('data-country-id');
                if (selectedCountryId === '' || countryId !== selectedCountryId) {
                    checkbox.parentElement.parentElement.style.display = 'none';
                } else {
                    checkbox.parentElement.parentElement.style.display = 'block';
                }
            });
        });
    </script> --}}

@endsection
