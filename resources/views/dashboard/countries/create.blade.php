@extends('dashboard.index')

@section('title', 'انشاء منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('countries.index')}}">الدول</a></li>
    <li class="breadcrumb-item">انشاء دولة</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{route('countries.store')}}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="col-sm-10">

                            <select name="country_id" id="country" class="form-select">
                                <option value="" hidden>الدولة</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name_ar }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-3">المدن</h4>
                                        <div data-repeater-list="group-a">
                                            <div class="row" data-repeater-item>


                                                @forelse ($cities as $city)
                                                    <div class="mb-3 col-lg-2" style="display: none;"
                                                         data-country-id="{{ $city->country_id }}">
                                                        <div class="form-check">
                                                            <input class="form-check-input city-checkbox"
                                                                   type="checkbox"
                                                                   value="{{ $city->id }}"
                                                                   name="city[]"
                                                                   id="city_{{$city->id}}"
                                                                   data-country-id="{{ $city->country_id }}">

                                                            <label class="form-check-label" for="city_{{$city->id}}">
                                                                {{ $city->name_ar }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div>لا يوجد مدن</div>
                                                @endforelse
                                                <!-- end col -->
                                                <!-- end col -->
                                            </div>
                                            <!-- end row -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div>
                            <button class="btn btn-primary" type="submit">حفظ</button>
                        </div>
                    </form>


                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    </script>

@endsection
