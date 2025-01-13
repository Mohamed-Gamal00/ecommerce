@extends('dashboard.index')
@section('title', 'النصوص المتحركه')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">النصوص المتحركه</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success'/>
                    <x-alert type='dark'/>

                    <div class="button-items text-end mb-4">
                        <a type="submit" href="{{ route('header_text.create') }}"
                           class="btn btn-primary waves-effect waves-light">اضافة نص متحرك</a>
                    </div>
                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                            <tr>
                                <th>عنوان النص</th>
                                <th>تاريخ الانشاء</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                            </thead>


                            <tbody>
                            @forelse ($headerText as $text)
                                <tr data-id="5">
                                    <td data-field="id">{{ Str::limit($text->title, 40) }}</td>
                                    <td data-field="gender">{{ $text->created_at->format('Y-m-d H:i') }}</td>

                                    {{-- @can('header_text.edit') --}}
                                        <td style="width: 7%;">
                                            <a href="{{ route('header_text.edit', $text->id) }}"
                                               style="font-size: 12px" ;
                                               class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    {{-- @endcan --}}

                                    {{-- @can('header_text.delete') --}}
                                        <form method="post" action="{{ route('header_text.destroy', $text->id) }}"
                                              id=formDelete_{{ $text->id }}>
                                            @csrf
                                            @method('delete')
                                            <td style="width: 7%;">
                                                <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{$text->id}})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </form>
                                    {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد نصوص متحركه لعرضها
                                        </td>
                                </tr>
                            @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
