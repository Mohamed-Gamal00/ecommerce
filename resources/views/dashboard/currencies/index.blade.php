@extends('dashboard.index')
@section('title', 'العملات')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">العملات</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <x-alert type='success'/>
                    <x-alert type='info'/>
                    <x-alert type='dark'/>
                    {{-- @can('currency.create') --}}
                        @if(!empty($defaultCurrency))
                            <div class="button-items text-end mb-4">
                                <a type="submit" href="{{ route('currencies.create') }}"
                                   class="btn btn-primary waves-effect waves-light">اضافة
                                                                                    عملة
                                                                                    جديده</a>
                                @endif

                                <a type="submit" href="{{ route('default_currency') }}"
                                   class="btn btn-dark waves-effect waves-light"> العملة الافتراضيه</a>
                            </div>
                        {{-- @endcan --}}


                        <div class="table-responsive mt-2">

                            @if(!empty($defaultCurrency))
                                <table
                                    class="table table-editable table-nowrap align-middle table-edits table-striped table-bordered mt-2"
                                    id="country-table">
                                    <thead>
                                    <tr>
                                        <th>العملة</th>
                                        <th>السعر بـ الـ{{$defaultCurrency->name_ar}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                    @forelse ($currencies as $currency)
                                        <tr data-id="5">
                                            <td data-field="id">{{ $currency->name_ar}}</td>
                                            <td data-field="id">{{ $currency->price_in_default_currency}}</td>
                                            {{-- @can('currency.edit') --}}
                                                <td style="width: 5%;">
                                                    <a href="{{ route('currencies.edit', $currency->id) }}"
                                                       class="btn btn-primary waves-effect waves-light" title="تعديل">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            {{-- @endcan --}}
                                            {{-- @can('currency.delete') --}}
                                                <form method="post" id="formDelete_{{ $currency->id }}"
                                                      action="{{ route('currencies.destroy', $currency->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <td style="width: 5%;">
                                                        <button style="font-size: 12px;"
                                                                class="btn btn-danger waves-effect waves-light"
                                                                title="حذف"
                                                                type="button"
                                                                onclick="confirmDelete({{ $currency->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </form>
                                            {{-- @endcan --}}
                                            @empty
                                                <td colspan="6">
                                                    لا يوجد عملات لعرضها
                                                </td>
                                        </tr>
                                    @endforelse
                                </table>
                            @endif

                            @if(empty($defaultCurrency))
                                برجاء تعيين العمله الافتراضيه اولا
                            @endif
                            <!-- end table -->
                            {{--                        {{ $currencies->withQueryString()->links() }}--}}
                        </div>
                        <!-- end -->
                </div>
            </div>
        </div> <!-- end col -->
    </div>

@endsection
