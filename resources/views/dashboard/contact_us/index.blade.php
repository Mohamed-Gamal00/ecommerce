@extends('dashboard.index')
@section('title', 'الرسائل')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">الرسائل</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success'/>
                    <x-alert type='warning'/>
                    <x-alert type='dark'/>

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>رقم الهاتف</th>
                                <th>تاريخ الارسال</th>
                                <th>مشاهدة</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse ($messages as $message)
                                <tr data-id="5">
                                    <td data-field="id">{{ $message->name }}</td>
                                    <td data-field="id">{{ $message->email }}</td>
                                    <td data-field="id">{{ $message->phone_number }}</td>
                                    <td data-field="id">{{ $message->created_at }}</td>
                                    {{-- @can('discounts.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('contact_us.watch', $message->id)}}?notification_id={{$notifications->where('data.message_id', $message->id)->value('id')}}"
                                               style="font-size: 12px; background-color: {{ $notifications->where('data.message_id', $message->id)->whereNull('read_at')->isNotEmpty() ? 'red' : '#2794c7' }}"
                                               class="btn btn-primary waves-effect waves-light" title="مشاهدة">
                                                <i class="fion ion-md-eye"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    @empty
                                        <td colspan="6">
                                            لا يوجد رسائل لعرضها لعرضها
                                        </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $messages->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
