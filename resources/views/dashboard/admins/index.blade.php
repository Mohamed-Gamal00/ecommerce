@extends('dashboard.index')
@section('title', 'المدراء')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">المدراء</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success'/>
                    <x-alert type='dark'/>
                    <x-alert type='danger'/>

                    {{-- @can('admin.create') --}}
                        <div class="button-items text-end mb-4">
                            <a type="submit" href="{{ route('admins.create') }}"
                               class="btn btn-primary waves-effect waves-light">اضافة مدير جديد</a>
                        </div>
                    {{-- @endcan --}}

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>اسم المدير</th>
                                <th>البريد الالكتروني</th>
                                <th>تاريخ الانشاء</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse ($admins as $admin)
                                <tr data-id="5">

                                    <td data-field="id">{{ $admin->name }}</td>
                                    <td data-field="id">{{ $admin->email }}</td>
                                    <td data-field="gender">{{ $admin->created_at->format('Y-m-d H:i') }}</td>

                                    {{-- @can('admin.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('admins.edit', $admin->id) }}" style="font-size: 12px" ;
                                               class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    {{-- @can('admin.delete') --}}
                                        <form method="post" action="{{ route('admins.destroy', $admin->id) }}">
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
                                            لا يوجد بنرات لعرضها
                                        </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $admins->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
