<?php

use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\DiscountCodeController;
use App\Http\Controllers\Dashboard\NotificationsController;
use App\Http\Controllers\Dashboard\OrderStatusController;
use App\Http\Controllers\Dashboard\ProductAvailabilityController;
use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\AdvertisementController;
use App\Http\Controllers\Dashboard\BulkOrderController;
use App\Http\Controllers\Dashboard\ChoiceController;
use App\Http\Controllers\Dashboard\CityController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\CommonQuestionController;
use App\Http\Controllers\Dashboard\CompaniesController;
use App\Http\Controllers\Dashboard\CountriesController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\DesignsController;
use App\Http\Controllers\Dashboard\HeaderBanerController;
use App\Http\Controllers\Dashboard\HeaderTextController;
use App\Http\Controllers\Dashboard\MainCategoriesController;
use App\Http\Controllers\Dashboard\MainCategoriesSettingsController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProductSettingsController;
use App\Http\Controllers\Dashboard\ProductsFeatures;
use App\Http\Controllers\Dashboard\ReportsController;
use App\Http\Controllers\Dashboard\ReturnOrderController;
use App\Http\Controllers\Dashboard\RulesController;
use App\Http\Controllers\Dashboard\SendNewsToUsersController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ShippingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProfileSettingsController;
use App\Http\Controllers\Dashboard\RepresentativesOrderController;
use App\Http\Controllers\Dashboard\Shipping\ShippingCompanyController;
use App\Http\Controllers\Dashboard\StoreFatuerController;
use App\Livewire\Categories;
use App\Livewire\MainCategorySettings;
use Illuminate\Support\Facades\Route;

//=============================================== Dashboard Routes

// Handle login submission
Route::post('/login', [AdminsController::class, 'login'])->name('admin.login.post');

// Handle logout

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::post('/logout', [AdminsController::class, 'logout'])->name('admin.logout');

    //-----------------------------------------------------------------------------/ Main Page
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    //-----------------------------------------------------------------------------/ Notifications Page
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications.index');

    //-----------------------------------------------------------------------------/Profile Settings
    Route::get('/profile/edit', [ProfileSettingsController::class, 'index'])->name('profile.settings.index');
    Route::put('/profile/update', [ProfileSettingsController::class, 'changePassword'])->name('profile.settings.update');

    //-----------------------------------------------------------------------------/ContactUs
    Route::get('/contact_us_view', [ContactUsController::class, 'index'])->name('contact_us.index');
    Route::get('/contact_us_view/{id}/show', [ContactUsController::class, 'show'])->name('contact_us.watch');

    //-----------------------------------------------------------------------------/Profile Info
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update');

    //----------------------------------------------/ Users News Routes
    Route::get('/send_news', [SendNewsToUsersController::class, 'create'])->name('user_news.create');
    Route::post('/send_news_mail', [SendNewsToUsersController::class, 'sendNewsMail'])->name('user_news.send');

    // ------------------------------------------------------/ Website Settings
    Route::get('/front_settings', [SettingsController::class, 'index'])->name('front_settings');
    Route::put('/front_settings/{id}/update', [SettingsController::class, 'update'])->name('settings.update');

    //-----------------------------------------------------------------------------/colors
    Route::resource('colors', ColorController::class);

    //-----------------------------------------------------------------------------/Designs
    Route::resource('/designs', DesignsController::class);

    Route::resource('/banners', App\Http\Controllers\Dashboard\NewHeaderBannerController::class);


    //-----------------------------------------------------------------------------/ShippingCompany
    // Route::get('/shipping_companies', [ShippingCompanyController::class, 'index'])->name('shipping.index');

    Route::resource('/shipping_companies', ShippingCompanyController::class);
    Route::get('/get-cities/{countryId}', [ShippingCompanyController::class, 'getCities']);

    //-----------------------------------------------------------------------------/softDelete Products
    Route::get('/products/trash', [productsController::class, 'trash'])->name('products.trash');
    Route::put('/products/{id}/restore', [productsController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force-delete', [productsController::class, 'forceDelete'])->name('products.force-delete');

    //----------------------------------------------/Main Categories
    Route::resource('/main_categories', MainCategoriesController::class);

    //----------------------------------------------/Choices
    Route::resource('/main_choices', ChoiceController::class);

    //----------------------------------------------/Filters Settings
    Route::get('/sub_filters/{id}/view', [MainCategoriesSettingsController::class, 'subFilterView'])->name('sub_filters.index');
    Route::post('/sub_filters/store', [MainCategoriesSettingsController::class, 'subFilterStore'])->name('sub_filters.store');
    Route::delete('/sub_filters/{id}/delete', [MainCategoriesSettingsController::class, 'subFilterDestroy'])->name('sub_filters.delete');
    Route::get('/sub_filters/{id}/edit', [MainCategoriesSettingsController::class, 'subFilterEdit'])->name('sub_filters.edit');
    Route::put('/sub_filters/{id}/update', [MainCategoriesSettingsController::class, 'subFilterUpdate'])->name('sub_filters.update');

    Route::resource('/filters', MainCategoriesSettingsController::class);

    //----------------------------------------------/Products routes
    // Route::post('/header_banner/delete', [HeaderBanerController::class, 'frontHeaderRemoveImage'])->name('headerImage.remove');

    Route::post('/product_images/delete', [ProductsController::class, 'imageDelete'])->name('image.delete');

    Route::get('/sub_category/{categoryId}', [ProductsController::class, 'subCategory'])->name('sub_category');
    Route::post('/search', [ProductsController::class, 'search'])->name('search');
    Route::get('/products/out_of_stock', [ProductsController::class, 'outOfStock'])->name('out_of_stock');
    Route::get('/fetch-choices', [ProductsController::class, 'fetchChoices'])->name('fetch.choices');

    Route::resource('/products', ProductsController::class);

    //----------------------------------------------/Products Settings routes
    Route::get('/products_settings/{id}/filters', [ProductSettingsController::class, 'productFilters'])->name('products.filters');
    Route::put('/products_settings/{id}/update', [ProductSettingsController::class, 'productFiltersUpdate'])->name('products.filters.update');
    Route::delete('/products_settings/destroy_all', [ProductSettingsController::class, 'destroyAll'])->name('destroy.all');

    Route::resource('/products_settings', ProductSettingsController::class);

    //----------------------------------------------/Companies routes
    Route::resource('/companies', CompaniesController::class);

    //----------------------------------------------/stores routes
    Route::resource('/store_featuers', StoreFatuerController::class);

    //----------------------------------------------/Admins routes
    Route::put('/admins/{id}/update_password', [AdminsController::class, 'ChangePassword'])->name('admins.update_password');
    Route::resource('/admins', AdminsController::class);

    //----------------------------------------------/Clients routes
    Route::put('/clients/{id}/update_pass', [ClientsController::class, 'updatePassword'])->name('client.update_password');
    Route::resource('/clients', ClientsController::class);

    //----------------------------------------------/Admins Rules routes
    Route::resource('/rules', RulesController::class);

    //----------------------------------------------/Header Text
    Route::resource('/header_text', HeaderTextController::class);
    //----------------------------------------------/Header Banner
    // Route::resource('/header_banner', HeaderBanerController::class);
    Route::get('/header_banner', [HeaderBanerController::class, 'index'])->name('header_banner.index');
    Route::post('/header_banner/delete', [HeaderBanerController::class, 'frontHeaderRemoveImage'])->name('headerImage.remove');
    Route::post('/header_banner/store', [HeaderBanerController::class, 'frontHeaderStoreAndUpdate'])->name('header_banner.sotreAndUpdate');
    /*english header banners*/
    Route::get('/header_banner_en', [HeaderBanerController::class, 'index_en'])->name('header_banner_en.index');
    Route::post('/header_banner_en/delete', [HeaderBanerController::class, 'frontHeaderRemoveImage_en'])->name('headerImage_en.remove');
    Route::post('/header_banner_en/store', [HeaderBanerController::class, 'frontHeaderStoreAndUpdate_en'])->name('header_banner_en.sotreAndUpdate');

    //----------------------------------------------/Animated Advertisements
    Route::resource('advertisements', AdvertisementController::class);

    //----------------------------------------------/static pages
    Route::resource('pages', PageController::class);

    Route::resource('dashboard/common_questions', CommonQuestionController::class);

    //----------------------------------------------/Representatives Orders

    Route::resource('representatives_orders', RepresentativesOrderController::class);

    //----------------------------------------------/bulk orders
    Route::resource('bulk_orders', BulkOrderController::class);

    //----------------------------------------------/payments
    Route::get('/payments', [\App\Http\Controllers\Dashboard\PaymentController::class, 'index'])->name('payments.index');

    //----------------------------------------------/Countries and Cities
    Route::get('/countries/{countryId}/cities', [CountriesController::class, 'getCitiesByCountry']);
    Route::resource('/countries', CountriesController::class);
    Route::resource('/cities', CityController::class);


    //----------------------------------------------/Currencies
    Route::get('/currencies/default_currency', [CurrencyController::class, 'setDefaultCurrency'])->name('default_currency');
    Route::put('/currencies/change_default_currency', [CurrencyController::class, 'updateDefaultCurrency'])->name('change_default_currency');
    Route::resource('/currencies', CurrencyController::class);

    //----------------------------------------------/ Orders Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{id}/update', [OrderController::class, 'update'])->name('orders.update');

    //----------------------------------------------/ Return Orders Routes
    Route::get('/return_orders', [ReturnOrderController::class, 'index'])->name('return_orders.index');
    Route::get('/return_orders/{id}', [ReturnOrderController::class, 'show'])->name('return_orders.show');
    Route::delete('/return_orders/{id}/delete', [ReturnOrderController::class, 'destroy'])->name('return_orders.destroy');
    Route::put('/return_orders/{id}/update', [ReturnOrderController::class, 'update'])->name('return_orders.update');

    //----------------------------------------------/ product_availability Route /---------------------------
    Route::resource('/product_availability', ProductAvailabilityController::class);

    //----------------------------------------------/DiscountCode routes
    Route::resource('/discount_code', DiscountCodeController::class);
    Route::get('/api/search-products', [DiscountCodeController::class, 'searchProducts'])->name('search.products');

    //----------------------------------------------/ Orders Routes
    Route::get('/shipping_types', [ShippingController::class, 'index'])->name('shipping.index');
    Route::get('/shipping_types/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
    Route::put('/shipping_types/{id}/update', [ShippingController::class, 'update'])->name('shipping_data.update');
    Route::get('/get-cities', [ShippingController::class, 'getCities'])->name('get-cities');
    Route::get('/order_status/arranging', [OrderStatusController::class, 'orderArrangement'])->name('order_status.arranging');
    Route::put('/order_status/arranging/update', [OrderStatusController::class, 'orderArrangementUpdate'])->name('order_status.arranging_update');
    Route::resource('/order_status', OrderStatusController::class);

    //----------------------------------------------/ Reports Routes

    //----------------------------------------------/ Reports Routes
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/searchReport', [ReportsController::class, 'searchReport'])->name('search_report');
});

//----------------------------------------------/Admin login
Route::view('admin/login', 'admin.auth.login')->middleware('guest:admin')->name('admin.login');
Route::post('/admin/login', [AdminsController::class, 'login'])->name('admin.login.store');
