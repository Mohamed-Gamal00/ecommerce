@extends('dashboard.index')
@section('title', 'تعديل المجموعة')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('rules.index') }}">المجموعات</a></li>
    <li class="breadcrumb-item">تعديل المجموعة</li>
@endsection

@section('section')

    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Form Start --}}
                    <form method="post" action="{{ route('rules.update', $rule->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label">اسم المجموعة</label>
                            <div class="col-sm-10">
                                <x-form.input name="name" type="text" value="{{$rule->name}}" id="example-text-input" />

                                {{-- <input class="form-control" name="name" type="text" id="example-text-input"
                                       value="{{$rule->name}}">
                                @error('name')
                                <span class="error">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>

                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div> <!-- end col -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Form Start --}}
                        <h4 class="text-center">الصلاحيات</h4>

                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div> <!-- end col -->

            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                <label class="form-check-label fw-bold" for="selectAllCheckbox">تحديد الكل</label>
            </div>

            <x-admin.rules rules_type="products" title="المنتجات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="categories" title="الأقسام" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="filters" title="التصنيفات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="companies" title="الشركات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="designs" title="التصميم" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="admins" title="المدراء" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="groups" title="المجموعات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="orders" title="الطلبات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="return_orders" title="ارجاع الطلبات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="news" title="النشرة الأخبارية" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="settings" title="اعدادات الموقع" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="shipping" title="الشحن" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="discount_code" title="أكود الخصم" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="order_status" title="حالات الطلب" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="product_availability" title="حالات التوفر" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="currencies" title="العملات" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="countries" title="الدول" :rule_abilities="$rule_abilities" />
            <x-admin.rules rules_type="colors" title="الالوان" :rule_abilities="$rule_abilities" />


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
