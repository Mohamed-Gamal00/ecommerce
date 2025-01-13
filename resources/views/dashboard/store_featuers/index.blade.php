@extends('dashboard.index')
@section('title', 'مميزات الموقع')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">مميزات الموقع</li>

@endsection

@section('section')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />
                    <div class="button-items text-end mb-4">
                        <a type="submit" href="{{ route('store_featuers.create') }}"
                            class="btn btn-primary waves-effect waves-light">اضافة ميزة
                        </a>
                    </div>

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>الصورة</th>
                                    <th>العنوان</th>
                                    <th>الوصف</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($featuers as $featuer)
                                    <tr data-id="5">
                                        <td style="width: 7%;" data-field="id"><img alt=""
                                                class="img-thumbnail rounded me-2" width="30" height="30"
                                                src="{{ $featuer->image_url }}" data-holder-rendered="true">
                                        </td>
                                        <td data-field="id">{{ $featuer->title }}</td>
                                        <td data-field="id">{{ $featuer->description }}</td>
                                        <td data-field="gender">{{ $featuer->created_at->format('Y-m-d H:i') }}</td>

                                            <td style="width: 7%;">
                                                <a href="{{ route('store_featuers.edit', $featuer->id) }}" style="font-size: 12px" ;
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>

                                            <form method="post" action="{{ route('store_featuers.destroy', $featuer->id) }}"
                                                id=formDelete_{{ $featuer->id }}>
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $featuer->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                    @empty
                                        <td colspan="6" class="text-center">
                                            لا يوجد منتجات لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $featuers->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
