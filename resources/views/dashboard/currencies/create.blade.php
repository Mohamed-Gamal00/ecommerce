@extends('dashboard.index')

@section('title', 'اضافة عملة جديده')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('currencies.index')}}">العملات</a></li>
    <li class="breadcrumb-item">انشاء عملة</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('currencies.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="col-sm-10">
                            <select name="currency_id" id="currency" class="form-select">
                                <option value="" hidden>العملات</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name_ar }}</option>
                                @endforeach
                            </select>
                            @error('currency_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-12 mt-3">
                            <label for="example-text-input" class="col-sm-4 col-form-label fw-bold">سعر العملة بـ
                                                                                                    الـ{{$defaultCurrency->name_ar}}
                            </label>
                            <div class="col-sm-10">
                                <x-form.input type="number" name="price_in_default_currency" step=".01"
                                              placeholder="ادخل سعر العمله مقابل 1 {{$defaultCurrency->name_ar}}"/>
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary mt-3" type="submit">حفظ</button>
                        </div>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('currency').addEventListener('change', function () {
            var selectedCountryId = this.value;
            var cityCheckboxes = document.querySelectorAll('.city-checkbox');

            cityCheckboxes.forEach(function (checkbox) {
                var currencyId = checkbox.getAttribute('data-currency-id');
                if (selectedCountryId === '' || currencyId !== selectedCountryId) {
                    checkbox.parentElement.parentElement.style.display = 'none';
                } else {
                    checkbox.parentElement.parentElement.style.display = 'block';
                }
            });
        });
    </script>

@endsection
