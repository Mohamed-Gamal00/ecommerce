@extends('dashboard.index')

@section('section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <x-alert type="success" />
                        <x-alert type='danger' />
                        <div class="card-body">

                            <h4 style="font-family:kufi;" class="card-title">إضافة فلتر جديد</h4>
                            <form class="repeater" method="post" action="{{ route('sub_main_settings.sotre') }}">
                                @csrf
                                <div data-repeater-list="group-a">
                                    <div class="row" data-repeater-item>
                                        <div class="mb-3 col-lg-4">
                                            <label class="form-label" for="name">اسم الفلتر</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="" />
                                            <input type="hidden" name="main_category_setting_id"
                                                value="{{ $categoryId }}" class="form-control" />
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2 mt-sm-0"> إضافه</button>
                            </form>
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

                            <div class="card-title">جميع الفلاتر الخاصه بالأقسام</div>


                            <table class="table table-editable table-nowrap align-middle table-edits table-striped">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($settings as $setting)
                                        <tr data-id="5">

                                            <td colspan="2" data-field="id">{{ $setting->name }}</td>
                                            <td style="width: 100px">
                                                <a href="" class="btn btn-secondary btn-sm edit" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>
                                            <form action="{{ route('sub_main_settings.delete', $setting->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <td style="width: 100px">
                                                    <button class="btn btn-danger btn-sm edit" type="submit"
                                                        title="حذف">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>

                                        @empty
                                            <td colspan="6">
                                                لا يوجد فلاتر لعرضها
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <!-- end tbody -->
                            </table>
                            {{-- {{ $settings->withQueryString()->links() }} --}}

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection
