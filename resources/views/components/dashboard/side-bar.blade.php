<div id="sidebar-menu">
    <!-- Left Menu Start -->
    <ul class="metismenu list-unstyled" id="side-menu">
        <a href="{{ route('dashboard.index') }}">
            <li class="menu-title title">لوحة التحكم</li>
        </a>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="ti-home"></i>
                <span>الواجهة الرئيسية</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('products.index') }}">المنتجات</a></li>


                    <li><a href="{{ route('out_of_stock') }}">منتجات قاربت على النفاذ</a></li>


                    <li><a href="{{ route('main_categories.index') }}">الاقسام</a></li>


                    <li><a href="{{ route('main_choices.index') }}">الخيارات</a></li>


                    <li><a href="{{ route('products_settings.index') }}">خيارات المنتج</a></li>


                    <li><a href="{{ route('filters.index') }}">التصنيفات</a></li>


                    <li><a href="{{ route('colors.index') }}">الألوان</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="fa fa-building"></i>
                <span>الشركات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('companies.create') }}">اضافة</a></li>


                    <li><a href="{{ route('companies.index') }}">مشاهدة</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="fa fa-paint-brush"></i>
                <span>التصميم</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('designs.index') }}">البنرات</a></li>


                    <li><a href="{{ route('banners.index') }}">البنرات المتحركة</a></li>


            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="{{ $unreadOrderCreatedCount > 0 ? '' : 'has-arrow' }} waves-effect">
                @if ($unreadOrderCreatedCount > 0)
                    <span class="badge rounded-pill bg-danger float-end">{{ $unreadOrderCreatedCount }}</span>
                @endif
                <i class="far fa-credit-card"></i> <span>المبيعات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('orders.index') }}">الطلبات</a></li>


                    <li><a href="{{ route('return_orders.index') }}">ارجاع الطلبات</a></li>

                <li><a href="{{ route('payments.index') }}">المدفوعات</a></li>

                    <li><a href="{{ route('bulk_orders.index') }}">طلبات الشراء بالجملة</a></li>


                    <li><a href="{{ route('representatives_orders.index') }}">طلبات المناديب</a></li>

            </ul>
        </li>
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="fas fa-users"></i> <span>قائمة العملاء</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('clients.index') }}">العملاء</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="fas fa-cogs"></i> <span>الضبط</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('front_settings') }}">الاعدادات</a></li>

                {{--
					<li><a href="{{route('header_text.index')}}">النصوص المتحركه</a></li>
				 --}}

                    <li><a href="{{ route('advertisements.index') }}">شريط اعلاني متحرك</a></li>


                    <li><a href="{{ route('currencies.index') }}">العملات</a></li>


                    <li><a href="{{ route('countries.index') }}">الدول</a></li>


                    <li><a href="{{ route('cities.index') }}">المدن</a></li>


                    <li><a href="{{ route('product_availability.index') }}">حالات التوفر</a></li>


                    <li><a href="{{ route('order_status.index') }}">حالة الطلب</a></li>


                    <li><a href="{{ route('discount_code.index') }}">أكود الخصم</a></li>


                    <li><a href="{{ route('shipping.index') }}">الشحن</a></li>


                    <li><a href="{{ route('shipping_companies.index') }}">شركات الشحن</a></li>


                    <li><a href="{{ route('user_news.create') }}">النشرة البريدية</a></li>

                <li><a href="{{ route('store_featuers.index') }}">ميزات المتجر</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="fas fa-users-cog"></i> <span>قائمة المدراء</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('admins.index') }}">المدراء</a></li>


                    <li><a href="{{ route('rules.index') }}">المجموعات</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="{{ $unreadMessageCount > 0 ? '' : 'has-arrow' }} waves-effect">
                @if ($unreadMessageCount > 0)
                    <span class="badge rounded-pill bg-danger float-end">{{ $unreadMessageCount }}</span>
                @endif
                <i class="fas fa-mail-bulk"></i> <span>الرسائل</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">

                    <li><a href="{{ route('contact_us.index') }}">مشاهدة الرسائل</a></li>

            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="far fa-address-book"></i> <span>التقارير</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('reports.index') }}">صفحة التقارير</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="far fa-address-book"></i> <span>الصفحات</span>
            </a>
            <ul class="sub-menu" aria-expanded="false">
                <li><a href="{{ route('pages.index') }}">صفحات الموقع</a></li>
                <li><a href="{{ route('common_questions.index') }}">الاسئلة الشائعة</a></li>
            </ul>
        </li>
    </ul>
</div>
