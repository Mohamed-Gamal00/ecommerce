@extends('dashboard.index')
@section('title', 'الشحن')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('shipping.index') }}">الشحن</a></li>

@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>الاستلام من المتجر</th>
                                    <th>تكلفة الشحن بالوزن</th>
                                    <th>تكلفة ثابته للشحن</th>
                                    <th>تكلفة الشحن بناءا على المنطقة</th>
                                    <th>سعر الشحن للكيلو</th>
                                    <th>سعر الشحن الثابت</th>
                                    <th>تعديل</th>
                                </tr>
                            </thead>


                            @if ($shippingData)
                                <tbody>
                                    <tr data-id="5">

                                        <td data-field="id">{{ $shippingData->add_pickup_from_store ? 'مفعل' : 'غير مفعل' }}
                                        </td>
                                        <td data-field="id">{{ $shippingData->add_wight_price ? 'مفعل' : 'غير مفعل' }}</td>
                                        <td data-field="id">{{ $shippingData->add_normal_price ? 'مفعل' : 'غير مفعل' }}</td>
                                        <td data-field="id">
                                            {{ $shippingData->add_price_based_on_city ? 'مفعل' : 'غير مفعل' }}</td>
                                        <td data-field="id">{{ $shippingData->weight_price }}</td>
                                        <td data-field="id">{{ $shippingData->normal_shipping_price }}</td>
                                        {{-- <td data-field="id">
                                            @if ($shippingData->status == '1')
                                                نشط
                                            @elseif($shippingData->status == '0')
                                                غير نشط
                                            @endif
                                        </td> --}}

                                        {{-- @can('product.edit') --}}
                                            <td style="width: 5%;">
                                                <a href="{{ route('shipping.edit', $shippingData->id) }}"
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="9">لا يوجد شركات لعرضها</td>
                                    </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
