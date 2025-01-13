@extends('dashboard.index')
@section('title', 'التصنيفات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">التصنيفات</li>
@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-alert type="success"/>
                    <x-alert type='danger'/>
                    <x-alert type='dark'/>
                    {{-- @can('filter.create') --}}
                        <h4 class="card-title mt-3">إضافة تصنيف جديد</h4>
                        <form class="repeater" method="post" action="{{ route('filters.store') }}">
                            @csrf
                            <div data-repeater-list="group-a">
                                <div class="row" data-repeater-item>
                                    <div class="mb-3 col-lg-4">
                                        <label class="form-label" for="name">اسم التصنيف</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                               placeholder=""/>
                                        @error('name')
                                        <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-2 mt-sm-0">اضافة</button>
                        </form>
                    {{-- @endcan --}}
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    {{-- Form End --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">جميع التصنيفات الخاصه بالأقسام</div>


                    <table class="table table-editable table-nowrap align-middle table-edits table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($settings as $setting)
                            <tr data-id="5">
                                <td colspan="" data-field="id">{{ $setting->name }}</td>
                                {{-- @can('sub_filter.create') --}}
                                    <td style="width: 100px">
                                        <a href="{{ route('sub_filters.index', $setting->id) }}"
                                           class="btn btn-purple waves-effect waves-light">
                                            <span>اضافة تصنيف فرعي</span>
                                        </a>
                                    </td>
                                {{-- @endcan --}}

                                {{-- @can('filter.edit') --}}
                                    <td style="width: 100px">
                                        <a href="{{ route('filters.edit', $setting->id) }}"
                                           class="btn btn-secondary btn-sm edit" title="تعديل">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                {{-- @endcan --}}

                                {{-- @can('sub_filter.view') --}}
                                    <td style="width: 100px">
                                        <a href="{{ route('sub_filters.index', $setting->id) }}"
                                           class="btn btn-secondary btn-sm edit" title="مشاهدة">
                                            <i class="ion ion-md-eye"></i>
                                        </a>
                                    </td>
                                {{-- @endcan --}}

                                {{-- @can('filter.delete') --}}
                                    <form action="{{ route('filters.destroy', $setting->id) }}"
                                          method="post" id="formDelete_{{$setting->id}}">
                                        @csrf
                                        @method('delete')

                                        <td style="width: 7%;">
                                            <button style="font-size: 12px;"
                                                    class="btn btn-danger waves-effect waves-light" title="حذف"
                                                    type="button" onclick="confirmDelete({{$setting->id}})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </form>
                                {{-- @endcan --}}


                                @empty
                                    <td colspan="6">
                                        لا يوجد تصنيفات لعرضها
                                    </td>
                            </tr>
                        @endforelse
                        </tbody>
                        <!-- end tbody -->
                    </table>
                    {{ $settings->withQueryString()->links() }}

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
