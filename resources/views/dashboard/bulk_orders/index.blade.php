@extends('dashboard.index')
@section('title', 'طلبات الشراء بالجملة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">طلبات الشراء بالجملة</li>
@endsection

@section('section')

    <div class="container">
        <x-alert type='success' />
        <x-alert type='info' />
        <x-alert type='dark' />
        <div class="container">
            {{-- <a href="{{ route('representatives_orders.create') }}" class="btn btn-primary">اضافة طلب</a> --}}

            <div class="container">
                {{-- <a href="{{ route('bulk_orders.create') }}" class="btn btn-primary">اضافة طلب</a> --}}

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>اسم الشركة او الجهة</th>
                            <th>انواع المنتجات المطلوبة</th>
                            {{-- <th>اعدادات</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->company_name }}</td>
                                <td> <button type="button" class="btn btn-primary" data-id="{{ $order->id }}"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop-{{ $order->id }}">
                                        التفاصيل
                                    </button></td>
                                {{-- <td>
                                    <a href="{{ route('bulk_orders.edit', $order->id) }}" class="btn btn-dark">تعديل</a>
                                    <form action="{{ route('bulk_orders.destroy', $order->id) }}" method="POST"
                                        style="display:inline-block;" id=formDelete_{{ $order->id }}>
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $order->id }})"
                                            class="btn btn-danger">حذف</button>
                                    </form>
                                </td> --}}

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop-{{ $order->id }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">الوصف</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p id="orderDetails"> {{ $order->description }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
