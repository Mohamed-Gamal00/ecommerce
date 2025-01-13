@extends('dashboard.index')

@section('title', 'المحذوفات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">المنتجات</a></li>
    <li class="breadcrumb-item">المحذوفات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type='success' />
                    <x-alert type='dark' />

                    <div class="button-items text-end">
                        <a href="{{ route('products.index') }}" class="btn btn-primary waves-effect waves-light">الرجوع
                            لصفحة
                            المنتجات</a>
                    </div>


                    <div class="table-responsive">

                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>اسم المنتج</th>
                                    <th>السعر</th>
                                    <th>القسم</th>
                                    <th>تاريخ الحذف</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($products as $product)
                                    <tr data-id="5">
                                        <td data-field="id"><img class="img-thumbnail rounded me-2" width="100"
                                                height="100" src="{{ asset($product->image_url) }}"
                                                data-holder-rendered="true">
                                        </td>
                                        <td data-field="id">{{ $product->CurrentNameLang }}</td>
                                        <td data-field="name">{{ $product->price }}</td>
                                        <td data-field="name">{{ $product->parent->name ?? '-' }}</td>
                                        <td data-field="gender">{{ $product->deleted_at->format('Y-m-d H:i') }}</td>
                                        {{-- @can('product.restore') --}}
                                            <form method="post" action="{{ route('products.restore', $product->id) }}">
                                                @csrf
                                                @method('put')
                                                <td>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                        title="تعديل">ارجاع
                                                        المنتج</i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                        {{-- @can('product.delete.forever') --}}
                                            <form method="post" action="{{ route('products.force-delete', $product->id) }}">
                                                <td>
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="submit">حذف المنتج
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="8">
                                            لا يوجد منتجات لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
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
