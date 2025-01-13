@extends('dashboard.index')

@section('title', 'العملة الافتراضيه')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('currencies.index')}}">العملات</a></li>
    <li class="breadcrumb-item">العملة الافتراضيه</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('change_default_currency')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <div class="col-sm-10">
                            <select name="default_currency_id" id="currency" class="form-select">
                                <option value="" hidden>العملات</option>
                                @forelse ($currencies as $currency)
                                    <option
                                        value="{{ $currency->id }}"

                                        {{$defaultCurrency && $defaultCurrency->id == $currency->id ? 'selected' : ''}}

                                    >{{ $currency->name_ar }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('default_currency_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
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
