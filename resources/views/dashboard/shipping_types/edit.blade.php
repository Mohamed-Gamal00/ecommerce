@extends('dashboard.index')
@section('title', ' الشحن')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('shipping.index') }}">الشحن</a></li>
    <li class="breadcrumb-item"><a href="">تعديل طرق الشحن</a></li>

@endsection

@section('section')
    <x-alert type="success" />
    <form class="repeater" action="{{ route('shipping_data.update', 1) }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="message-list" style="list-style-type: none">

                            <h5>تفعيل امكانية الاستلام من المتجر</h5>
                            <li class="mb-5">
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk1" name="add_pickup_from_store" value="1"
                                            {{ $shippingData->add_pickup_from_store == true ? 'checked' : '' }}>
                                        <label for="chk1" class="toggle"></label>
                                    </div>
                                    <span class="fw-bold">الاستلام من المتجر</span>
                                </div>
                            </li>


                            <h5>اختيار نوع تكلفة الشحن</h5>
                            <li>
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk3" name="add_wight_price" value="1"
                                            {{ $shippingData->add_wight_price == true ? 'checked' : '' }}>
                                        <label for="chk3" class="toggle"></label>
                                    </div>
                                    <span href="#" class="fw-bold">تكلفة الشحن بالوزن</span>
                                </div>
                            </li>

                            <li>
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk2" name="add_normal_price" value="1"
                                            {{ $shippingData->add_normal_price == true ? 'checked' : '' }}>
                                        <label for="chk2" class="toggle"></label>
                                    </div>
                                    <span class=" fw-bold">تكلفة ثابته للشحن</span>
                                </div>
                            </li>

                            <li>
                                <div class="col-mail col-mail-1">
                                    <div class="checkbox-wrapper-mail">
                                        <input type="checkbox" id="chk4" name="add_price_based_on_city" value="1"
                                            {{ $shippingData->add_price_based_on_city == true ? 'checked' : '' }}>
                                        <label for="chk4" class="toggle"></label>
                                    </div>
                                    <span class=" fw-bold">تكلفة الشحن بناءا على المنطقة</span>
                                </div>
                            </li>

                        </ul>

                        <div class="row mb-3 mt-5">
                            <label class="col-sm-2 col-form-label fw-bold">سعر الشحن للكيلو</label>
                            <div class="col-sm-8">
                                <x-form.input type="number" name="weight_price" :value="$shippingData->weight_price" />
                            </div>
                        </div>

                        <div class="row mb-3 mt-5">
                            <label class="col-sm-2 col-form-label fw-bold">سعر الشحن الثابت</label>
                            <div class="col-sm-8">
                                <x-form.input type="number" name="normal_shipping_price" :value="$shippingData->normal_shipping_price" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <h4 class="card-title mb-2 mt-2">اضافة أو تعديل تكلفة الشحن لكل منطقة</h4>

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">


                        <div data-repeater-list="group-a">
                            <div class="row" data-repeater-item>
                                <h5 class="card-title mb-2 mt-2">اختيار الدولة</h5>
                                <div class="col-sm-10 mb-5">
                                    <select name="country_id" class="form-select country-select">
                                        <option value="" hidden>الدولة</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="city-container"></div>
                            </div>
                        </div>

                        @forelse ($cities as $city)
                            <div class="city-wrapper-template" style="display: none;"
                                data-country-id="{{ $city->country_id }}">
                                <div class="row city-wrapper" data-repeater-item>
                                    <div class="mb-3 col-lg-2">
                                        <input class="form-control city-input" type="text" value="{{ $city->name_ar }}"
                                            name="city_name[]" readonly>
                                    </div>
                                    <div class="mb-3 col-lg-2">
                                        <input class="form-control price-input" type="text" placeholder="السعر"
                                            name="price[]">
                                    </div>
                                    @error('city_name')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        @empty
                            <div>لا يوجد مدن</div>
                        @endforelse
                        <!-- end col -->


                        <!-- end row -->
                        {{--                        <input data-repeater-create type="button" class="btn btn-success mt-2 mt-sm-0" value="Add"/> --}}
                    </div>


                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">حفظ التعديلات</button>
    </form>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title"> عرض اسعار الشحن لكل منطقة</h4>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                            <tr>
                                <th class="fw-bold">الدولة</th>
                                <th class="fw-bold">المدينة</th>
                                <th class="fw-bold">سعر الشحن</th>
                            </tr>
                        </thead>


                        @forelse($cities as $city)
                            <tbody>
                                @if ($city->shipping_price)
                                    <tr>
                                        <td>{{ $city->country->name_ar }}</td>
                                        <td>{{ $city->name_ar }}</td>
                                        <td>{{ $city->shipping_price }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        @empty
                            <td>لا يوجد دول لعرضها</td>
                        @endforelse
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <script>
        const chk1 = document.getElementById('chk1');
        const chk2 = document.getElementById('chk2');
        const chk3 = document.getElementById('chk3');
        const chk4 = document.getElementById('chk4');


        chk2.addEventListener('change', function () {
            if (chk2.checked) {
                chk4.checked = false;
            }
        });


        chk4.addEventListener('change', function () {
            if (chk4.checked) {
                chk2.checked = false;
            }
        });


        $(document).on('change', '.country-select', function () {
            var selectedCountryId = $(this).val();
            var cityContainer = $(this).closest('[data-repeater-item]').find('.city-container');

            $.ajax({
                url: '/admin/dashboard/get-cities',
                method: 'GET',
                data: {country_id: selectedCountryId},
                success: function (response) {
                    cityContainer.empty();
                    $.each(response, function (key, city) {
                        var cityWrapper = $('<div class="row city-wrapper" data-repeater-item></div>');
                        cityWrapper.append('<div class="mb-3 col-lg-2"><input class="form-control city-input" type="text" value="' + city.name_ar + '" name="city_name[]" readonly></div>');
                        cityWrapper.append('<div class="mb-3 col-lg-2"><input class="form-control price-input" type="text" ' +
                            (city.shipping_price ? 'value="' + city.shipping_price + '"' : '') +
                            ' placeholder="السعر" name="price[' + city.id + ']""></div>');


                        cityContainer.append(cityWrapper);


                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/shipping_type_blade.js') }}"></script>
        
        <script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
        
        <script src="{{ asset('assets/js/pages/form-repeater.int.js') }}"></script>
        
    @endpush

@endsection
