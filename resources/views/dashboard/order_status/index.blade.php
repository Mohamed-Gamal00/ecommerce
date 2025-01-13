@extends('dashboard.index')
@section('title', 'حالات الطلب')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">حالات الطلب</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='info' />
                    <x-alert type='dark' />

                    {{-- @can('order_status.create') --}}
                        <div class="button-items text-end mb-4">
                            <a type="submit" href="{{ route('order_status.create') }}"
                                class="btn btn-primary waves-effect waves-light">اضافة حالة طلب جديده</a>

                            <a type="submit" href="{{ route('order_status.arranging') }}"
                                class="btn btn-dark waves-effect waves-light">ترتيب حالات الطلب </a>
                        </div>
                    {{-- @endcan --}}


                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>اسم حالة الطلب</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($orderStatus as $status)
                                    <tr data-id="5">
                                        <td data-field="id">{{ $status->CurrentNameLang }}</td>
                                        {{-- @can('order_status.edit') --}}
                                            <td style="width: 7%;">
                                                <a href="{{ route('order_status.edit', $status->id) }}" style="font-size: 12px"
                                                    ; class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('order_status.delete') --}}
                                            <form method="post" action="{{ route('order_status.destroy', $status->id) }}"
                                                id=formDelete_{{ $status->id }}>
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $status->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد حالات لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $orderStatus->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
