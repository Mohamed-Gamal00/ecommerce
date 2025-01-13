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
    <li class="breadcrumb-item active" aria-current="page"> التقارير</li>
@endsection

@section('section')
    <x-alert type="success" />

    {{-- <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <div data-repeater-list="group-a">
                        <div class="row" data-repeater-item>
                            <h5 class="card-title mb-3 mt-2">جميع التقارير</h5>
                            <div class="col-sm-10 mb-5">
                                <select name="country_id" class="form-select country-select">
                                    <option value="" hidden>برجاء إختيار نوع التقرير</option>
                                    @foreach ($reportTitle as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="city-container"></div>
                        </div>
                    </div>


            </div>
            <button class="btn btn-primary" type="submit">مشاهدة التقرير</button>

        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title mb-3 mt-2">فلتر</h5>

                    <div class="col-sm-10 mb-5">

                        <div style="display: ruby-text;" class="mb-3">
                            <div style="width: 45%" class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="من بداية تاريخ..."
                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1'
                                    data-provide="datepicker">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                            <div style="width: 45%" class="input-group" id="datepicker1">
                                <input type="text" class="form-control" placeholder="الى نهاية تاريخ..."
                                    data-date-format="dd M, yyyy" data-date-container='#datepicker1'
                                    data-provide="datepicker">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>

                        </div>
                    </div>

                    </form>
                </div>
            </div>


        </div>
    </div> --}}


    <div class="card-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#home2" role="tab">
                    <span class="d-none d-md-block">تقارير عامة </span><span class="d-block d-md-none"><i
                            class="mdi mdi-home-variant h5"></i></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#profile2" role="tab">
                    <span class="d-none d-md-block">تقارير عن سلة المنتجات</span><span class="d-block d-md-none"><i
                            class="mdi mdi-account h5"></i></span>
                </a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            {{-- التقارير العامة --}}
            <div class="tab-pane active p-3" id="home2" role="tabpanel">
                <div class="row">
                    <form action="{{ route('search_report') }}" method="post">
                        @csrf
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <div data-repeater-list="group-a">
                                        <div class="row" data-repeater-item>
                                            <h5 class="card-title mb-3 mt-2">جميع التقارير</h5>
                                            <div class="col-sm-4 mb-5">
                                                <select name="report_type" class="form-select country-select">
                                                    <option value="">برجاء إختيار نوع التقرير</option>
                                                    @foreach ($reportTitle as $key => $val)
                                                        <option value="{{ $key }}">{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                                @error('report_type')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-4 mb-5">
                                                <div style="" class="mb-3">
                                                    <div style="width: 100%" class="input-group" id="datepicker1">
                                                        <input type="text" name="start_at" class="form-control"
                                                            placeholder="تاريخ البداية" data-date-format="yyyy-mm-dd"
                                                            data-date-container='#datepicker1' data-provide="datepicker">
                                                    </div>
                                                    <div>
                                                        @error('start_at')
                                                            <span class="error">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-5">
                                                <div style="" class="mb-3">
                                                    <div style="width: 100%" class="input-group" id="datepicker1">
                                                        <input type="text" name="end_at" class="form-control"
                                                            placeholder="تاريخ النهاية" data-date-format="yyyy-mm-dd"
                                                            data-date-container='#datepicker1' data-provide="datepicker">

                                                        {{-- <input type="date" name="end_at" class="form-control">
                                                        <span class="input-group-text"><i
                                                                class="mdi mdi-calendar"></i></span> --}}
                                                    </div>
                                                    @error('end_at')
                                                        <span class="error">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-3">
                                    <button type="submit" class="btn btn-dark fw-bold">عرض</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>


            {{-- تقارير عن سلة المنتجات --}}
            <div class="tab-pane  p-3" id="profile2" role="tabpanel">
                <div class="row">
                    <div class="col-12">
                        تقارير سلة المنتجات

                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>اسم المنتج</th>
                                    <th>عدد مرات الاضافة</th>
                                    <th>عدد مرات الشراء</th>
                                    <th>مشاهدة</th>
                                </tr>
                            </thead>


                            @if (!$products->isEmpty())
                                <tbody>
                                    @forelse ($products as $product)
                                        <tr data-id="5">
                                            <td>{{ $product->CurrentNameLang }}</td>
                                            <td>{{ $product->cart_count }}</td>
                                            <td>{{ $product->order_count }}</td>


                                            {{-- @can('product.edit') --}}
                                                <td style="width: 5%;">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-primary waves-effect waves-light" title="مشاهدة">
                                                        <i class="fas fa-eye"></i>
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
                        </table>
                        {{-- {{ $products->withQueryString()->links() }} --}}
                    </div><!-- end card -->
                </div> <!-- end col -->
            </div>
        </div>


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
