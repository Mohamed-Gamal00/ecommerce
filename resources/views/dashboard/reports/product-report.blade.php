@extends('dashboard.index')

@section('css')
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css">
@endsection

@section('title', 'التقارير')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('reports.index') }}">
            التقارير

        </a>
    </li>
@endsection

@section('section')
    <x-alert type="success" />
    <div>
        <div class="container">
            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                <thead>
                    <tr>
                        <th>اسم المنتج</th>
                        <th>حالة المنتج</th>
                        <th>حالة التوفر</th>
                        <th>السعر</th>
                        <th>السعر قبل الخصم</th>
                        <th>الوزن (كجم)</th>
                        <th>القسم</th>
                        <th>الكمية</th>
                        <th>مشاهدة</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr data-id="5">
                            <td data-field="id">{{ $product->CurrentNameLang }}</td>
                            <td data-field="id">
                                @if ($product->status == 'active')
                                    نشط
                                @elseif($product->status == 'archived')
                                    غير نشط
                                @endif
                            </td>
                            <td data-field="id">{{ $product->availability->CurrentNameLang }}</td>
                            <td data-field="name">{{ $product->price }}</td>
                            <td data-field="name">{{ $product->discount_price ?? '-' }}</td>
                            <td data-field="name">{{ $product->weight }}</td>
                            <td data-field="name">{{ $product->parent->name ?? '-' }}</td>
                            <td data-field="name">{{ $product->quantity }}</td>
                            <td style="width: 5%;">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-primary waves-effect waves-light" title="مشاهدة">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        @empty
                            <td colspan="6">
                                لا يوجد منتجات لعرضها
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
