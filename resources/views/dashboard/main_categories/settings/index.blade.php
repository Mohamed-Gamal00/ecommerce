@extends('dashboard.index')

@section('section')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <x-alert type="success" />
                            <x-alert type='danger' />

                            <h4 style="font-family:kufi;" class="card-title">إضافة فلتر جديد</h4>
                            <form class="repeater" method="post" action="{{ route('categories_settings.store') }}">
                                @csrf
                                <div data-repeater-list="group-a">
                                    <div class="row" data-repeater-item>
                                        <div class="mb-3 col-lg-4">
                                            <label class="form-label" for="name">اسم الفلتر</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                placeholder="" />
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
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($settings as $setting)
                                        <tr data-id="5">

                                            <td colspan="2" data-field="id"><a
                                                    href="{{ route('sub_main_settings', $setting->id) }}">{{ $setting->name }}</a>
                                            </td>

                                            <td style="width: 100px">
                                                <a href="{{ route('sub_main_settings', $setting->id) }}"
                                                    class="btn btn-purple waves-effect waves-light">
                                                    <span>اضافة فلتر فرعي</span>
                                                </a>
                                            </td>

                                            <td style="width: 100px">
                                                <a href="" class="btn btn-secondary btn-sm edit" title="تعديل">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </td>

                                            <form action="{{ route('categories_settings.destroy', $setting->id) }}"
                                                method="post" id="formDelete">
                                                @csrf
                                                @method('delete')

                                                <td style="width: 7%;">
                                                    <button style="font-size: 12px;"
                                                            class="btn btn-danger waves-effect waves-light" title="حذف"
                                                            type="button" onclick="confirmDelete('deleteForm2')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </form>


                                        @empty
                                            <td colspan="6">
                                                لا يوجد منتجات لعرضها
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

        </div> <!-- container-fluid -->
    </div>



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.editable-input').hide();

            $('.edit').click(function() {
                var row = $(this).closest('tr');
                row.find('.editable-field').hide();
                row.find('.editable-input').show();
            });

            $('.editable-input').focusout(function() {
                var row = $(this).closest('tr');
                var fieldValue = row.find('.editable-input').val();
                var settingId = row.data('id');

                $.ajax({
                    type: 'PATCH',
                    url: '/update-data/' + settingId,
                    data: {
                        name: fieldValue,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        row.find('.editable-field').text(fieldValue).show();
                        row.find('.editable-input').hide();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('.delete').click(function() {
                if (!confirm('Are you sure you want to delete this record?')) {
                    return false;
                }
            });
        });
    </script>
@endsection
