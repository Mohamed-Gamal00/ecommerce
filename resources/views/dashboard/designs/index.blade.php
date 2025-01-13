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
                    {{--
                                       @can('design.create')
                                           <div class="button-items text-end">
                                               <a type="submit" href="{{ route('designs.create') }}"
                                                  class="btn btn-primary waves-effect waves-light ">انشاء بنر جديد</a>
                                           </div>
                                       @endcan --}}

                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>بنرات الصفحة الرئيسية</th>
                                    <th>عنوان البنر</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>تعديل</th>
                                    {{--                                <th>حذف</th> --}}
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($home_banners as $design)
                                    <tr data-id="5">
                                        <td class="align-middle text-center" style="width: 7%;" data-field="id">
                                            <img alt="" class="img-thumbnail rounded me-2" width="30"
                                                height="30" src="{{ $design->image_url }}" data-holder-rendered="true">
                                        </td>
                                        <td data-field="id">{{ $design->title }}</td>
                                        {{--                                            <td data-field="name">{{ $product->product_quantity }}</td> --}}
                                        <td data-field="gender">{{ $design->created_at->format('Y-m-d H:i') }}</td>

                                        {{-- @can('design.edit') --}}
                                            <td style="width: 7%;">
                                                <a href="{{ route('designs.edit', $design->id) }}" style="font-size: 12px" ;
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('design.delete')
                                                                               @if (!$design->main_banar)
                                                                                   <form method="post" action="{{ route('designs.destroy', $design->id) }}"
                                                                                         id=formDelete_{{ $design->id }}>
                                                                                       @csrf
                                                                                       @method('delete')
                                                                                       <td style="width: 7%;">
                                                                                           <button style="font-size: 12px;"
                                                                                                   class="btn btn-danger waves-effect waves-light" title="حذف"
                                                                                                   type="button" onclick="confirmDelete({{$design->id}})">
                                                                                               <i class="fas fa-trash-alt"></i>
                                                                                           </button>
                                                                                       </td>
                                                                                   </form>
                                                                               @endif
                                                                           @endcan --}}

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


                    <div class="table-responsive mt-2">

                        <table
                            class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                            id="product-table">
                            <thead>
                                <tr>
                                    <th>بنرات صفحة العروض</th>
                                    <th>عنوان البنر</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>تعديل</th>
                                    {{--                                <th>حذف</th> --}}
                                </tr>
                            </thead>


                            <tbody>
                                @forelse ($offer_banners as $design)
                                    <tr data-id="5">
                                        <td class="align-middle text-center" style="width: 7%;" data-field="id">
                                            <img alt="" class="img-thumbnail rounded me-2" width="30"
                                                height="30" src="{{ $design->image_url }}" data-holder-rendered="true">
                                        </td>
                                        <td data-field="id">{{ $design->title }}</td>
                                        {{--                                            <td data-field="name">{{ $product->product_quantity }}</td> --}}
                                        <td data-field="gender">{{ $design->created_at->format('Y-m-d H:i') }}</td>

                                        {{-- @can('design.edit') --}}
                                            <td style="width: 7%;">
                                                <a href="{{ route('designs.edit', $design->id) }}" style="font-size: 12px" ;
                                                    class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                        {{-- @endcan --}}

                                        {{-- @can('design.delete')
                                                                               @if (!$design->main_banar)
                                                                                   <form method="post" action="{{ route('designs.destroy', $design->id) }}"
                                                                                         id=formDelete_{{ $design->id }}>
                                                                                       @csrf
                                                                                       @method('delete')
                                                                                       <td style="width: 7%;">
                                                                                           <button style="font-size: 12px;"
                                                                                                   class="btn btn-danger waves-effect waves-light" title="حذف"
                                                                                                   type="button" onclick="confirmDelete({{$design->id}})">
                                                                                               <i class="fas fa-trash-alt"></i>
                                                                                           </button>
                                                                                       </td>
                                                                                   </form>
                                                                               @endif
                                                                           @endcan --}}

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
                    <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
