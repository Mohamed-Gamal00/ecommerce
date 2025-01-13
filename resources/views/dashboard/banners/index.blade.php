@extends('dashboard.index')
@section('title', 'البنرات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">البنرات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='dark' />
                    <x-alert type='danger' />

                    {{-- @can('design.create') --}}
                    <div class="button-items text-end">
                        <a type="submit" href="{{ route('banners.create') }}"
                            class="btn btn-primary waves-effect waves-light ">انشاء بنر جديد</a>
                    </div>
                    {{-- @endcan --}}

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>بنرات لغة عربية</th>
                                    <th>بنرات لغة انجليزية</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($home_banners as $design)
                                    <tr data-id="5">
                                        <td class="align-middle text-center" style="width: 7%;" data-field="id">
                                            <img alt="" class="me-2" width="150" height="70"
                                                src="{{ asset('storage/' . $design->header_image) }}"
                                                data-holder-rendered="true">
                                        </td>
                                        <td class="align-middle text-center" style="width: 7%;" data-field="id">
                                            <img alt="" class="me-2" width="150" height="70"
                                                src="{{ asset('storage/' . $design->header_image_en) }}"
                                                data-holder-rendered="true">
                                        </td>

                                        {{-- @can('design.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('banners.edit', $design->id) }}" style="font-size: 12px" ;
                                                class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                        {{-- @endcan --}}

                                        {{-- @can('design.delete') --}}

                                        <form method="post" action="{{ route('banners.destroy', $design->id) }}"
                                            id=formDelete_{{ $design->id }}>
                                            @csrf
                                            @method('delete')
                                            <td style="width: 7%;">
                                                <button style="font-size: 12px;"
                                                    class="btn btn-danger waves-effect waves-light" title="حذف"
                                                    type="button" onclick="confirmDelete({{ $design->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
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
                        {{--                        {{ $designs->withQueryString()->links() }} --}}
                    </div>


                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
