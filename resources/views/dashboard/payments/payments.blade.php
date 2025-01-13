@extends('dashboard.index')
@section('title', 'المدفوعات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">المدفوعات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success'/>
                    <x-alert type='danger'/>
                    <x-alert type='dark'/>

                    {{--                    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mt-5">--}}
                    {{--                        <x-form.input type="text" name="order_number" placeholder="البحث عن طريق رقم الطلب..."--}}
                    {{--                                      class="mx-2" :value="request('order_number')"/>--}}
                    {{--                        <button class="btn btn-dark">بحث</button>--}}
                    {{--                    </form>--}}

                    <div class="table-responsive mt-2">

                        <table
                                class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                                id="country-table">
                            <thead>
                            <tr>
                                <th class="fw-bold">رقم الطلب</th>
                                <th class="fw-bold">الحالة</th>
                                <th class="fw-bold">الوصف</th>
                                <th class="fw-bold">الاجمالي</th>
                                <th class="fw-bold">تاريخ العملية</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse($payments  as $payment)
                                <tr data-id="5">
                                    <td>
                                        {{$payment['id']}}
                                    </td>
                                    <td>
                                        @if($payment['status'] == 'paid')
                                            <span class="text-success">
                                            {{$payment['status']}}
                                            </span>
                                        @elseif($payment['status'] == 'failed')
                                            <span class="text-danger">
                                            {{$payment['status']}}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$payment['description']}}
                                    </td>
                                    <td>
                                        {{number_format($payment['amount'] / 100, 2)}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($payment['created_at'])->format('Y/m/d H:i:s')}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        لا يوجد طلبات لعرضها
                                    </td>
                                </tr>
                            @endforelse
                        </table>
                        <!-- end table -->
                        {{ $payments->links() }}
                        {{--                        {{ $payments->withQueryString()->links() }}--}}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
