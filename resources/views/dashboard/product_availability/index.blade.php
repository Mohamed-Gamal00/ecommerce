@extends('dashboard.index')
@section('title', 'الشركات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">الشركات</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success'/>
                    <x-alert type='info'/>
                    <x-alert type='dark'/>

                    {{-- @can('product_availability.create') --}}
                        <div class="button-items text-end mb-4">
                            <a type="submit" href="{{ route('product_availability.create') }}"
                               class="btn btn-primary waves-effect waves-light">اضافة حالة توفر جديده</a>
                        </div>
                    {{-- @endcan --}}
                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>اسم حالة التوفر</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse ($availabilities as $availability)
                                <tr data-id="5">
                                    <td data-field="id">{{ $availability->name }}</td>
                                    {{-- @can('product_availability.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('product_availability.edit', $availability->id) }}"
                                               style="font-size: 12px" ;
                                               class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    {{-- @can('product_availability.delete') --}}
                                        <form method="post"
                                              action="{{ route('product_availability.destroy', $availability->id) }}"
                                              id=formDelete_{{ $availability->id }}>
                                            @csrf
                                            @method('delete')
                                            <td style="width: 7%;">
                                                <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{$availability->id}})">
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
                        {{ $availabilities->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
