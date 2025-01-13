@extends('dashboard.index')
@section('title', 'ارجاع الطلبات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">ارجاع الطلبات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />

                    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mt-5">
                        <x-form.input type="text" name="order_number" placeholder="البحث عن طريق رقم الطلب..."
                            class="mx-2" :value="request('order_number')" />
                        <button class="btn btn-dark">بحث</button>
                    </form>


                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="country-table">
                            <thead>
                                <tr>
                                    <th class="fw-bold">رقم الطلب</th>
                                    <th class="fw-bold">اسم العميل</th>
                                    <th class="fw-bold">البريد الالكتروني</th>
                                    <th class="fw-bold">الدولة</th>
                                    <th class="fw-bold">المدينة</th>
                                    <th class="fw-bold">تاريخ ارجاع الطلب</th>
                                    <th class="fw-bold">مشاهدة</th>
                                    <th class="fw-bold">حذف</th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($orders as $order)
                                    <tr data-id="5">
                                        <td data-field="id">{{ $order->number }}</td>
                                        <td data-field="id">{{ $order->addresses->first()->first_name }}
                                            {{ $order->addresses->first()->last_name }}</td>
                                        <td data-field="id">{{ $order->user->id ? $order->user->email : 'زائر' }}</td>
                                        <td data-field="id">{{ $order->addresses->first()->country->name_ar ?? '-' }}</td>
                                        <td data-field="id">{{ $order->addresses->first()->city->name_ar ?? '-' }}</td>
                                        <td data-field="id">{{ $order->created_at->format('j/n/Y g:ia') }}</td>



                                        {{-- @can('return_order.edit') --}}
                                            <td style="width: 2%;text-align-last: center;">
                                                <a href="{{ route('return_orders.show', $order->id) }}"
                                                    class="btn btn-secondary btn-sm edit" title="مشاهدة">
                                                    <i class="ion ion-md-eye"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}
                                        {{-- @can('return_order.delete') --}}
                                            <form method="post" id="formDelete_{{ $order->id }}"
                                                action="{{ route('return_orders.destroy', $order->id) }}">
                                                @csrf
                                                @method('delete')
                                                <td style="width: 5%">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $order->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="10">
                                            لا يوجد طلبات لارجاعها
                                        </td>
                                    </tr>
                                @endforelse
                        </table>
                        <!-- end table -->
                        {{ $orders->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
