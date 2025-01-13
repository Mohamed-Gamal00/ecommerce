@extends('dashboard.index')

@section('title', 'خيارات المنتج')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">خيارات المنتج</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='dark' />
                    {{-- @can('product.trash.view') --}}
                        <div class="button-items text-end">
                            <a href="{{ route('products.trash') }}"
                                class="btn btn-dark waves-effect waves-light mb-5">المحذوفات</a>
                        </div>
                    {{-- @endcan --}}

                    <x-form.search-form :categories="$categories" :products="$products" />

                    <form action="{{ route('destroy.all') }}" method="post" id="formDelete">
                        @csrf
                        @method('delete')

                        {{-- @can('product.delete') --}}
                            <td style="width: 7%;">
                                <button class="btn btn-danger waves-effect waves-light" title="حذف" type="button"
                                    onclick="confirmDelete_()">
                                    حذف المنتجات
                                </button>
                            </td>
                        {{-- @endcan --}}

                        <div class="table-responsive mt-2">

                            <table class="table table-edits table-striped table-bordered mt-">
                                <thead>
                                    <tr>
                                        <th class="fw-bold"></th>
                                        <th class="fw-bold"></th>
                                        <th class="fw-bold">اسم المنتج</th>
                                        <th class="fw-bold">حالة المنتج</th>
                                        <th class="fw-bold">القسم الرئيسي</th>
                                        <th class="fw-bold">القسم الفرعي</th>
                                        <th class="fw-bold">التصنيفات</th>


                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($products as $product)
                                        <tr data-id="{{ $product->id }}">
                                            <td style="width: 3%;">
                                                <input class="form-check-input m-1" type="checkbox"
                                                    value="{{ $product->id }}" name="productId[]" style="height: 19px;">
                                            </td>
                                            <td colspan="1" data-field="id" style="width: 5%;">
                                                <img class="img-thumbnail rounded me-2" width="40" height="40"
                                                    src="{{ $product->image_url }}" data-holder-rendered="true">
                                            </td>
                                            <td data-field="id">{{ $product->CurrentNameLang }}</td>
                                            <td data-field="id">{{ $product->status }}</td>
                                            <td data-field="id">{{ $product->parent->CurrentNameLang }}</td>
                                            <td data-field="id">{{ $product->chiled->name ?? '-' }}</td>

                                            @csrf

                                            <td colspan="2">
                                                @forelse($product->subSettings as $filter)
                                                    <div class="btn-toolbar mb-0 d-inline">
                                                        <div class="btn btn-purple waves-effect waves-light mb-2 fs-17 p-1">
                                                            <span>{{ $filter->name }}</span>
                                                        </div>
                                                    </div>
                                                @empty
                                                    لا يوجد تصنيفات لعرضها
                                                @endforelse
                                            </td>

                                            {{-- @can('product_setting.filters') --}}
                                                <td style="width: 2%">
                                                    <a href="{{ route('products.filters', $product->id) }}"
                                                        class="btn btn-info btn-sm edit" title="تعديل">
                                                        التصنيفات
                                                    </a>
                                                </td>
                                            {{-- @endcan --}}

                                            {{-- @can('product.edit') --}}
                                                <td style="width: 2%">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-secondary btn-sm edit" title="تعديل">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            {{-- @endcan --}}

                                        @empty
                                            <td colspan="6">
                                                لا يوجد منتجات لعرضها
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <!-- end tbody -->
                            </table>

                    </form>
                    <!-- end table -->
                    {{ $products->links() }}
                </div>
                <!-- end -->
            </div>
        </div>
    </div> <!-- end col -->
    </div>
@endsection
