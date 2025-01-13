@extends('dashboard.index')
@section('title', 'انشاء مجموعة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('rules.index') }}">المجموعات</a></li>
    <li class="breadcrumb-item">انشاء مجموعة</li>
@endsection

@section('section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('rules.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">اسم المجموعة</label>
                            <div class="col-sm-10">
                                <x-form.input name="name" type="text" id="example-text-input" />

                                {{-- <input class="form-control" name="name" type="text" id="example-text-input"
								       value="">
								@error('name')
								<span class="error">{{ $message }}</span>
								@enderror --}}
                            </div>
                        </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->

        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
            <label class="form-check-label fw-bold" for="selectAllCheckbox">تحديد الكل</label>
        </div>

        <x-admin.rules rules_type="products" title="المنتجات" />
        <x-admin.rules rules_type="categories" title="الأقسام" />
        <x-admin.rules rules_type="filters" title="التصنيفات" />
        <x-admin.rules rules_type="companies" title="الشركات" />
        <x-admin.rules rules_type="designs" title="التصميم" />
        <x-admin.rules rules_type="admins" title="المدراء" />
        <x-admin.rules rules_type="groups" title="المجموعات" />
        <x-admin.rules rules_type="orders" title="الطلبات" />
        <x-admin.rules rules_type="return_orders" title="ارجاع الطلبات" />
        <x-admin.rules rules_type="news" title="النشرة الأخبارية" />
        <x-admin.rules rules_type="settings" title="اعدادات الموقع" />
        <x-admin.rules rules_type="shipping" title="الشحن" />
        <x-admin.rules rules_type="discount_code" title="أكود الخصم" />
        <x-admin.rules rules_type="order_status" title="حالات الطلب" />
        <x-admin.rules rules_type="product_availability" title="حالات التوفر" />
        <x-admin.rules rules_type="currencies" title="العملات" />
        <x-admin.rules rules_type="countries" title="الدول" />
        <x-admin.rules rules_type="colors" title="الالوان" />
        <x-admin.rules rules_type="reports" title="التقارير" />

        {{-- sub category in edit page --}}
        <div>
            <button class="btn btn-primary mt-5" type="submit">حفظ</button>
        </div>
        </form>
    </div>

    {{-- Form End --}}

    <script>
        document.getElementById('selectAllCheckbox').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.checkbox-item');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = this.checked;
            });
        });
    </script>

@endsection
