@extends('dashboard.index')
@section('title', 'المنتجات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">المنتجات</li>
    <li class="breadcrumb-item">منتجات قاربت علي النفاذ</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />

                    <x-form.search-form :categories="$categories" :products="$products" />

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>اسم المنتج</th>
                                    <th>الكمية</th>
                                    <th>تعديل</th>
                                </tr>
                            </thead>


                            @if (!$products->isEmpty())
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr data-id="5">
                                            <td style="width: 7%;" data-field="id"><img alt=""
                                                    class="img-thumbnail rounded me-2" width="50" height="50"
                                                    src="{{ $product->image_url }}" data-holder-rendered="true">
                                            </td>
                                            <td data-field="id">{{ $product->CurrentNameLang }}</td>

                                            <td data-field="name">{{ $product->quantity }}</td>
                                            {{-- @can('product.edit') --}}
                                                <td style="width: 5%;">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-primary waves-effect waves-light" title="تعديل">
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
                            @else
                                <tbody>
                                    <tr>
                                        <td colspan="9">لا يوجد منتجات لعرضها</td>
                                    </tr>
                                </tbody>
                            @endif
                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $products->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
