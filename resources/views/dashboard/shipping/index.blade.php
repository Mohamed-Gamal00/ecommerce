@extends('dashboard.index')
@section('title', 'الشحن')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">الشحن</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />
                    {{-- @can('product.create') --}}
                        <div class="button-items text-end mb-4">
                            <a type="submit" href="{{ route('shipping_companies.create') }}"
                                class="btn btn-primary waves-effect waves-light">اضافة شركة شحن
                            </a>
                        </div>
                    {{-- @endcan --}}

                    {{-- <x-form.search-form :categories="$categories" :shipping_companies="$shipping_companies" /> --}}

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th> الصورة</th>
                                    <th>اسم الشركة</th>
                                    <th>اسم المدن التي تشحن لها</th>
                                    <th>حالة الشركة</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>


                            @if (!$shippingCompanies->isEmpty())
                                <tbody>
                                    @forelse ($shippingCompanies as $company)
                                        <tr data-id="5">
                                            <td style="width: 7%;" data-field="id"><img alt=""
                                                    class="img-thumbnail rounded me-2" width="50" height="50"
                                                    src="{{ $company->image_url }}" data-holder-rendered="true">
                                            </td>
                                            <td data-field="id">{{ $company->CurrentNameLang }}</td>
                                            <td data-field="id">
                                                <ul>
                                                    @foreach ($company->shippingLocations as $location)
                                                        <li>{{ $location->city->name_ar }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td data-field="id">
                                                @if ($company->status == '1')
                                                    نشط
                                                @elseif($company->status == '0')
                                                    غير نشط
                                                @endif
                                            </td>

                                            {{-- @can('product.edit') --}}
                                                <td style="width: 5%;">
                                                    <a href="{{ route('shipping_companies.edit', $company->id) }}"
                                                        class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            {{-- @endcan --}}
                                            {{-- @can('product.delete') --}}
                                                <form method="post" id="formDelete_{{ $company->id }}"
                                                    action="{{ route('shipping_companies.destroy', $company->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <td style="width: 7%;">
                                                        <button style="font-size: 12px;"
                                                            class="btn btn-danger waves-effect waves-light" title="حذف"
                                                            type="button" onclick="confirmDelete({{ $company->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                            {{-- @endcan --}}
                                        @empty
                                            <td colspan="6">
                                                لا يوجد شركات لعرضها
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="9">لا يوجد شركات لعرضها</td>
                                    </tr>
                                </tbody>
                            @endif
                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{-- {{ $shippingCompanies->withQueryString()->links() }} --}}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
