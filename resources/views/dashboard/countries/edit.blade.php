@extends('dashboard.index')

@section('title', 'انشاء منتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">الدول</a></li>
    <li class="breadcrumb-item">تعديل دولة</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form action="{{ route('countries.update', $selectedCountry->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')


                        <div class="col-sm-10">
                            <select name="country_id" id="country" class="form-select">
                                <option value="" hidden>الدولة</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $country->id == $selectedCountry->id ? 'selected' : '' }}>
                                        {{ $country->name_ar }}
                                    </option>
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


                                                @foreach ($cities as $city)
                                                    <div class="mb-3 col-lg-2"
                                                        style="{{ $city->country_id == $selectedCountry->id ? '' : 'display: none;' }}"
                                                        data-country-id="{{ $city->country_id }}">
                                                        <div class="form-check">
                                                            <input class="form-check-input city-checkbox" type="checkbox"
                                                                value="{{ $city->id }}" name="city[]"
                                                                id="city_{{ $city->id }}"
                                                                data-country-id="{{ $city->country_id }}"
                                                                {{ $city->status == 'used' ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="city_{{ $city->id }}">
                                                                {{ $city->name_ar }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
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


    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/edit-countries_blade.js') }}"></script>
    @endpush
{{-- 
    <script>
        function showCitiesByCountry(selectedCountryId) {
            var cityCheckboxes = document.querySelectorAll('.city-checkbox');

            cityCheckboxes.forEach(function(checkbox) {
                var countryId = checkbox.getAttribute('data-country-id');
                if (selectedCountryId === '' || countryId !== selectedCountryId) {
                    checkbox.parentElement.parentElement.style.display = 'none';
                } else {
                    checkbox.parentElement.parentElement.style.display = 'block';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var selectedCountryId = document.getElementById('country').value;
            showCitiesByCountry(selectedCountryId);
        });

        document.getElementById('country').addEventListener('change', function() {
            var selectedCountryId = this.value;
            showCitiesByCountry(selectedCountryId);
        });
    </script> --}}

@endsection
