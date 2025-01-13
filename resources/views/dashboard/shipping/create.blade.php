@extends('dashboard.index')

@section('title', 'إضافة شركة شحن')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('shipping_companies.index') }}">شركات الشحن</a></li>
    <li class="breadcrumb-item active">إضافة شركة شحن</li>
@endsection

@section('section')

    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('shipping_companies.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group my-3">
                                <label for="name">اسم الشركة</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group my-3">
                                <label for="picture">الصورة</label>
                                <input type="file" name="picture" id="picture" class="form-control">
                            </div>

                            <div class="form-group my-3">
                                <label for="status">الحالة</label>
                                <select name="status" id="statu" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="0">غير نشط</option>
                                </select>
                            </div>

                            <div class="col-sm-10">
                                <button type="button" id="add-country-btn" class="btn btn-secondary mb-3">إضافة دولة
                                    أخرى</button>
                            </div>

                            <div id="country-city-container">
                                <div class="country-city-group mb-3">
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <select name="shipping_locations[0][countery_id]"
                                                class="form-select country-select">
                                                <option value="" hidden>الدولة</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name_ar }}</option>
                                                @endforeach
                                            </select>
                                            @error('countery_id')
                                                <span class="error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title mb-3">المدن</h4>
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <select name="shipping_locations[0][city_id]"
                                                                class="form-select city-select" required>
                                                                <option value="" disabled selected>اختر المدينة
                                                                </option>
                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city->id }}"
                                                                        data-country-id="{{ $city->country_id }}"
                                                                        style="display: none;">
                                                                        {{ $city->name_ar }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('city_id')
                                                                <span class="error">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group my-3">
                                                            <label for="shipping_price">سعر الشحن</label>
                                                            <input type="number"
                                                                name="shipping_locations[0][shipping_price]"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Function to update city options visibility based on selected country
                                    function updateCityOptions(countrySelect) {
                                        var selectedCountryId = countrySelect.value;
                                        var citySelect = countrySelect.closest('.country-city-group').querySelector('.city-select');

                                        citySelect.querySelectorAll('option').forEach(function(option) {
                                            var countryId = option.getAttribute('data-country-id');
                                            if (selectedCountryId === '' || countryId !== selectedCountryId) {
                                                option.style.display = 'none';
                                            } else {
                                                option.style.display = 'block';
                                            }
                                        });

                                        // Reset city select to default option
                                        citySelect.value = '';
                                    }

                                    // Handle country change
                                    document.querySelectorAll('.country-select').forEach(function(countrySelect) {
                                        countrySelect.addEventListener('change', function() {
                                            updateCityOptions(countrySelect);
                                        });
                                    });

                                    // Handle adding a new country
                                    document.getElementById('add-country-btn').addEventListener('click', function() {
                                        var container = document.getElementById('country-city-container');
                                        var countryCityGroup = container.querySelector('.country-city-group');
                                        var newGroup = countryCityGroup.cloneNode(true);
                                        var newIndex = container.querySelectorAll('.country-city-group').length;

                                        // Update name attributes for new group
                                        newGroup.querySelectorAll('select, input').forEach(function(element) {
                                            if (element.name) {
                                                element.name = element.name.replace(/\d+/, newIndex);
                                            }
                                        });

                                        // Add event listener for new country select
                                        newGroup.querySelector('.country-select').addEventListener('change', function() {
                                            updateCityOptions(this);
                                        });

                                        // Hide city options initially
                                        newGroup.querySelectorAll('.city-select option').forEach(function(option) {
                                            option.style.display = 'none';
                                        });

                                        container.appendChild(newGroup);
                                    });
                                });
                            </script>

                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
