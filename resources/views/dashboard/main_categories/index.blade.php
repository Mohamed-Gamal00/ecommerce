@extends('dashboard.index')
@section('title', 'الأقسام')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page"> الأقسام</li>
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
                            <a href="{{ route('main_categories.create') }}"
                                class="btn btn-primary waves-effect waves-light">إنشاء
                                قسم
                                جديد</a>
                        </div>
                    {{-- @endcan --}}


                    <div class="table-responsive">
                        <table class="table table-editable table-nowrap align-middle table-edits">
                            <thead>
                                <tr>
                                    <th>القسم</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($categories as $category)
                                    <tr data-id="5">

                                        <td colspan="2" data-field="id">
                                            {{ $category->CurrentNameLang }}
                                        </td>

                                        {{-- @can('category.edit') --}}
                                            <td style="width: 100px">
                                                <a href="{{ route('main_categories.edit', $category->id) }}"
                                                    class="btn btn-secondary btn-sm edit" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('category.delete') --}}
                                            <form action="{{ route('main_categories.destroy', $category->id) }}" method="post"
                                                id="formDelete_{{ $category->id }}">
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $category->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد أقسام لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $categories->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
