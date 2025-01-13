@extends('dashboard.index')
@section('title', 'أكود الخصم')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">أكود الخصم</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success'/>
                    <x-alert type='warning'/>
                    <x-alert type='dark'/>

                    {{-- @can('discount_code.create') --}}
                        <div class="button-items text-end mb-4">
                            <a type="submit" href="{{ route('discount_code.create') }}"
                               class="btn btn-primary waves-effect waves-light">اضافة كود خصم جديده</a>
                        </div>
                    {{-- @endcan --}}
                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>اسم كود الخصم</th>
                                <th>الكود</th>
                                <th>الخصم</th>
                                <th>عدد مرات الاستخدام المتاحه</th>
                                <th>الحالة</th>
                                <th>تعديل</th>
                                <th>حذف</th>
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
                                    {{-- @can('discount_code.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('discount_code.edit', $code->id) }}"
                                               style="font-size: 12px" ;
                                               class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    {{-- @can('discount_code.delete') --}}
                                        <form method="post"
                                              action="{{ route('discount_code.destroy', $code->id) }}"
                                              id=formDelete_{{ $code->id }}>
                                            @csrf
                                            @method('delete')
                                            <td style="width: 7%;">
                                                <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{$code->id}})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </form>
                                    {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد أكواد خصم لعرضها
                                        </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $discounts->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
