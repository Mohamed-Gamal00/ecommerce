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


                    <x-alert type='success' />
                    <x-alert type='danger' />
                    <x-alert type='dark' />


                    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mt-5">
                        <x-form.input name="name" placeholder="البحث عن..." class="mx-2" :value="request('name')" />
                        <button class="btn btn-dark">بحث</button>
                    </form>


                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>اسم الشركه</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>تعديل</th>
                                    <th>حذف</th>
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($companies as $company)
                                    <tr data-id="5">
                                        <td style="width: 7%;" data-field="id"><img alt=""
                                                class="img-thumbnail rounded me-2" width="30" height="30"
                                                src="{{ $company->image_url }}" data-holder-rendered="true">
                                        </td>
                                        <td data-field="id">{{ $company->CurrentNameLang }}</td>
                                        <td data-field="gender">{{ $company->created_at->format('Y-m-d H:i') }}</td>

                                        {{-- @can('company.edit') --}}
                                            <td style="width: 7%;">
                                                <a href="{{ route('companies.edit', $company->id) }}" style="font-size: 12px" ;
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('company.delete') --}}
                                            <form method="post" action="{{ route('companies.destroy', $company->id) }}"
                                                id=formDelete_{{ $company->id }}>
                                                @csrf
                                                @method('delete')
                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                        class="btn btn-danger waves-effect waves-light" title="حذف"
                                                        type="button" onclick="confirmDelete({{ $company->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        {{-- @endcan --}}
                                    @empty
                                        <td colspan="6">
                                            لا يوجد منتجات لعرضها
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <!-- end tbody -->
                        </table>
                        <!-- end table -->
                        {{ $companies->withQueryString()->links() }}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
