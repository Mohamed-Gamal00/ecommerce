@extends('dashboard.index')
@section('title', 'المنتجات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">المنتجات</li>
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
                        <a type="submit" href="{{ route('products.create') }}"
                            class="btn btn-primary waves-effect waves-light">إانشاء
                            منتج
                            جديد</a>
                    </div>
                    {{-- @endcan --}}

                    <x-form.search-form :categories="$categories" :products="$products" />

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>اسم المنتج</th>
                                    {{-- <th>حالة النشاط</th> --}}
                                    {{-- <th>حالة التوفر</th> --}}
                                    <th>السعر</th>
                                    {{-- <th>السعر بعد الخصم</th> --}}
                                    <th>الوزن (كجم)</th>
                                    <th>القسم</th>
                                    <th>الكمية</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
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
                                            {{-- <td data-field="id">
                                                @if ($product->status == 'active')
                                                    نشط
                                                @elseif($product->status == 'archived')
                                                    غير نشط
                                                @endif
                                            </td> --}}
                                            {{-- <td data-field="id">{{ $product->availability->CurrentNameLang }}</td> --}}
                                            <td data-field="name">{{ $product->price }}</td>
                                            {{-- <td data-field="name">{{ $product->discount_price ?? '-' }}</td> --}}
                                            <td data-field="name">{{ $product->weight }}</td>
                                            <td data-field="name">{{ $product->parent->name ?? '-' }}</td>
                                            <td data-field="name">{{ $product->quantity }}</td>
                                            {{-- @can('product.edit') --}}
                                            <td style="width: 5%;">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                            {{-- @endcan --}}
                                            {{-- @can('product.delete') --}}
                                            <form method="post" id="formDelete_{{ $product->id }}"
                                                action="{{ route('products.destroy', $product->id) }}">
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $product->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
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
