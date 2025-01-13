@extends('dashboard.index')
@section('title', 'المجموعات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{route('rules.index')}}">المجموعات</a></li>
@endsection
@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success'/>
                    <x-alert type='dark'/>
                    <x-alert type='danger'/>

                    {{-- @can('admin.group.create') --}}
                        <div class="button-items text-end">
                            <a type="submit" href="{{ route('rules.create') }}"
                               class="btn btn-primary waves-effect waves-light">اضافة مجموعة جديده</a>
                        </div>
                    {{-- @endcan --}}

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>اسم المجموعة</th>
                                <th>تاريخ الانشاء</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse ($rules as $rule)
                                <tr data-id="5">

                                    <td data-field="id">{{ $rule->name }}</td>
                                    {{--                                            <td data-field="name">{{ $product->product_quantity }}</td>--}}
                                    <td data-field="gender">{{ $rule->created_at->format('Y-m-d H:i') }}</td>

                                    {{-- @can('admin.group.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('rules.edit', $rule->id) }}" style="font-size: 12px;"
                                               class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    {{-- @can('admin.group.delete') --}}
                                        <form method="post" action="{{ route('rules.destroy', $rule->id) }}">
                                            @csrf
                                            @method('delete')
                                            <td style="width: 7%;">
                                                <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="submit"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </form>
                                    {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد مجموعات لعرضها
                                        </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $rules->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
