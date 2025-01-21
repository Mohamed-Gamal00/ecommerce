@extends('dashboard.index')
@section('title', 'الخيارات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page"> الخيارات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success' />
                    <x-alert type='dark' />
                    <x-alert type='danger' />


                    {{-- @can('category.create') --}}
                        <div class="button-items text-end">
                            <a href="{{ route('main_choices.create') }}" class="btn btn-primary waves-effect waves-light">إنشاء
                                خيار
                                جديد</a>
                        </div>
                    {{-- @endcan --}}


                    <div class="table-responsive">
                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($choices as $choice)
                                    <tr data-id="5">

                                        <td colspan="2" data-field="id">
                                            {{ $choice->CurrentNameLang }}
                                        </td>

                                        {{-- @can('category.edit') --}}
                                            <td style="width: 100px">
                                                <a href="{{ route('main_choices.edit', $choice->id) }}"
                                                    class="btn btn-secondary btn-sm edit" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('category.delete') --}}
                                            <form action="{{ route('main_choices.destroy', $choice->id) }}" method="post"
                                                id="formDelete_{{ $choice->id }}">
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $choice->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد خيارات لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $choices->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
