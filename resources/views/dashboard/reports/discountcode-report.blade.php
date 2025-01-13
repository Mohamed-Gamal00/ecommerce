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
                        <th>اسم كود الخصم</th>
                        <th>الكود</th>
                        <th>الخصم</th>
                        <th>عدد مرات الاستخدام المتاحه</th>
                        <th>الحالة</th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($discounts as $code)
                        <tr data-id="5">
                            <td data-field="id">{{ $code->name }}</td>
                            <td data-field="id">{{ $code->code }}</td>
                            <td data-field="id">{{ $code->price }}</td>
                            <td data-field="id">{{ $code->number_of_used }}</td>
                            <td data-field="id">{{ $code->status == 'active' ? 'نشط' : 'غير نشط' }}</td>



                        @empty
                            <td colspan="6">
                                لا يوجد أكواد خصم لعرضها
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
