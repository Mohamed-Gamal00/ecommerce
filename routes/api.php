<?php

use App\Http\Controllers\Api\AddToFavProductsController;
use App\Http\Controllers\Api\AllBannersController;
use App\Http\Controllers\Api\AllProductsController;
use App\Http\Controllers\Api\BrandsController;
use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\ColorsController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\CurrenciesController;
use App\Http\Controllers\Api\DiscountsController;
use App\Http\Controllers\Api\FilterProductsController;
use App\Http\Controllers\Api\GetAllFavProductsController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\LatestProductController;
use App\Http\Controllers\Api\MainCategoriesController;
use App\Http\Controllers\Api\ProductDetailsController;
use App\Http\Controllers\Api\Profile\PersonalInfoController;
use App\Http\Controllers\Api\Profile\UserAddressesController;
use App\Http\Controllers\Api\SearchProductController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\TopSellingProductsController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\ContactUsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*new*/

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\guest\GuestCartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\CheckDiscountController;
use App\Http\Controllers\Api\StaticPagesController;

/*
   |--------------------------------------------------------------------------
   | API Routes
   |--------------------------------------------------------------------------
   |
   | Here is where you can register API routes for your application. These
   | routes are loaded by the RouteServiceProvider and all of them will
   | be assigned to the "api" middleware group. Make something great!
   |
   */

Route::middleware(['changeLanguage'])->group(function () {

    Route::middleware('auth:user')->get('/user', function (Request $request) {
        return $request->user();
    });


    ###########################################################################-- User Profile
    Route::middleware('auth:user')->group(function () {
        #----------------------------------------------------------------------------------- Personal Info
        Route::post('change-personal-info', [PersonalInfoController::class, 'changePersonalInfo']);
        Route::post('change-password', [PersonalInfoController::class, 'changePassword']);
        Route::post('change-profile-image', [PersonalInfoController::class, 'changeProfileImage']);
        Route::get('user-info', [PersonalInfoController::class, 'getUserInfo']);

        #----------------------------------------------------------------------------------- User Addresses
        Route::get('user-addresses', [UserAddressesController::class, 'getAllAddresses']);
        Route::get('user-country-cities', [UserAddressesController::class, 'getUserCities']);
        Route::post('create-address', [UserAddressesController::class, 'createAddress']);
        Route::post('update-address/{id}', [UserAddressesController::class, 'updateAddress']);
        Route::delete('delete-address/{id}', [UserAddressesController::class, 'deleteAddress']);
        Route::post('main-address/{id}', [UserAddressesController::class, 'setMainAddress']);

        #-------------------------------------- Cart --------------------------------------------
        Route::prefix('cart')->group(function () {
            Route::post('add', [CartController::class, 'store']);
            Route::post('/update/{id}', [CartController::class, 'update']);
            Route::post('/delete/{id}', [CartController::class, 'destroy']);
            Route::get('/count', [CartController::class, 'getCartCount']);
            Route::get('/total-price', [CartController::class, 'getTotalPrice']);
            Route::get('/total-quantity', [CartController::class, 'getTotalQuantity']);
            Route::get('/', [CartController::class, 'index']);
        });

        #-------------------------------------- Checkout --------------------------------------------
        Route::post('/checkout', [CheckoutController::class, 'usercheckout']);

        #-------------------------------------- Check-Discount --------------------------------------------
        Route::post('/check-discount', CheckDiscountController::class);


        #-------------------------------------- user-orders --------------------------------------------
        Route::get('/user_show_order/{number}', [\App\Http\Controllers\Api\UserOrdersController::class, 'showOrder']);
        Route::get('/user_orders', [\App\Http\Controllers\Api\UserOrdersController::class, 'mainOrders']);
        Route::post('/user-orders/delete', [\App\Http\Controllers\Api\UserOrdersController::class, 'destroy']);
        /* المرتجعات */
        Route::get('/user-return-orders', [\App\Http\Controllers\Api\UserOrdersController::class, 'returns']);
        Route::post('/user-return-orders/store', [\App\Http\Controllers\Api\UserOrdersController::class, 'store']);
    });

    Route::get('/shipping-info', [CheckoutController::class, 'shippingInfo']);
    ###########################################################################-- Authentication
    Route::controller(UserAuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('verify-code', 'verifyCode');
        Route::post('resend-verify-code', [UserAuthController::class, 'resendVerifyCode']);
        Route::post('login', 'login');
        Route::post('forget-password', 'forgetPassword');
        Route::post('reset-password', [UserAuthController::class, 'resetPassword']);
        Route::post('logout', 'logout')->middleware('auth:user');
    });


    ###########################################################################-- Get All Countries
    // Route::get('get-countries', [CountriesController::class, 'allCountries']);

    ###########################################################################-- Get All Countries
    Route::get('get-cities', [CitiesController::class, 'allCities']);

    ####################################### Settings #############################################
    Route::get('settings', [SettingsController::class, 'settings']);


    ###########################################################################-- Get All Top Products
    Route::get('get-top-products', [TopSellingProductsController::class, 'topProducts']);
    Route::get('get-all-top-products', [TopSellingProductsController::class, 'allTopProducts']);


    ###########################################################################-- Get latest Product
    Route::get('get-latest-products', [LatestProductController::class, 'latestProducts']);
    Route::get('get-all-latest-products', [LatestProductController::class, 'allLatestProducts']);

    ###########################################################################-- Get All Main Categories
    Route::get('get-main-categories', [MainCategoriesController::class, 'mainCategories']);
    Route::get('get-all-categories', [MainCategoriesController::class, 'allMainCategories']);
    Route::get('get-sub-categories/{mainCateory}', [MainCategoriesController::class, 'subMainCategories']);


    ###########################################################################-- Get All Banners
    Route::get('get-header-banners', [AllBannersController::class, 'headerBanners']);
    Route::get('get-all-banners', [AllBannersController::class, 'allBanners']);

    ###########################################################################-- Get Discounts
    Route::get('discounts', [DiscountsController::class, 'discounts']);
    Route::get('all-discounts', [DiscountsController::class, 'allDiscounts']);

    ###########################################################################-- Search Product
    Route::get('search', [SearchProductController::class, 'search']);

    ###########################################################################-- Search Product
    Route::get('filter', [FilterProductsController::class, 'filterProducts']);

    ###########################################################################-- Get Colors
    Route::get('colors', ColorsController::class);

    ###########################################################################-- Get Brands
    Route::get('brands', BrandsController::class);

    ###########################################################################-- Get Products
    Route::get('products/{category_id}', AllProductsController::class);

    ###########################################################################-- Product Details Page
    Route::get('product-details/{id}', [ProductDetailsController::class, 'getProductDetails']);
    Route::get('product-colors/{id}', [ProductDetailsController::class, 'productColors']);
    Route::get('product-features/{id}', [ProductDetailsController::class, 'productFeatures']);
    Route::get('related-products/{id}', [ProductDetailsController::class, 'relatedProducts']);

    ###########################################################################-- Currency
    Route::get('default-currency', [CurrenciesController::class, 'defaultCurrency']);
    Route::get('all-currencies', [CurrenciesController::class, 'allCurrencies']);

    ###########################################################################-- Contact Us
    Route::post('contact-us', [ContactUsController::class, 'sendMessage']);

    ########################################################################### Create New Guest
    Route::post('create-guest', [GuestController::class, 'createGuest']);

    ########################################################################### Favorite Products

    Route::get('all-user-fav-products', [GetAllFavProductsController::class, 'userFavProducts'])->middleware('auth:user');
    Route::post('user-fav-product-add-or-delete', [AddToFavProductsController::class, 'userAddFavProducts'])->middleware('auth:user');

    Route::get('all-guest-fav-products', [GetAllFavProductsController::class, 'guestFavProducts']);
    Route::post('guest-fav-product-add-or-delete', [AddToFavProductsController::class, 'guestAddFavProducts']);
    Route::get('check-if-auth', [AddToFavProductsController::class, 'checkIfAuth'])->middleware('auth:user');
    Route::get('check-if-product-exists', [AddToFavProductsController::class, 'checkIfProductExists']);


    ############################################ orders ########################################
    Route::post('store-bulk-order', [\App\Http\Controllers\Api\BulkOrderController::class, 'store']);
    Route::post('store-represintative-order', [\App\Http\Controllers\Api\RepresentativeOrderController::class, 'storeorder']);

    ############################################ GUEST ##########################################
    ############################################ cart ##########################################

    Route::middleware('guest.header')->group(function () {
        Route::prefix('guest-cart')->group(function () {
            Route::post('add', [GuestCartController::class, 'guestStore']);
            Route::post('/update/{id}', [GuestCartController::class, 'guestUpdate']);
            Route::post('/delete/{id}', [GuestCartController::class, 'guestDestroy']);
            Route::get('/count', [GuestCartController::class, 'guestGetCartCount']);
            Route::get('/total-price', [GuestCartController::class, 'guestGetTotalPrice']);
            Route::get('/total-quantity', [GuestCartController::class, 'guestGetTotalQuantity']);
            Route::get('/', [GuestCartController::class, 'guestIndex']);
        });
        
        Route::post('/guest-checkout', [\App\Http\Controllers\Api\guest\CheckoutController::class, 'guestCheckout']);
        Route::post('/guest-check-discount', \App\Http\Controllers\Api\guest\GuestCheckDiscountController::class);

        #-------------------------------------- guest-orders --------------------------------------------
        Route::get('/guest-orders', [\App\Http\Controllers\Api\guest\GuestOrdersController::class, 'mainOrders']);
        Route::get('/guest-order/{number}', [\App\Http\Controllers\Api\guest\GuestOrdersController::class, 'showOrder']);
        Route::post('/guest-order/delete', [\App\Http\Controllers\Api\guest\GuestOrdersController::class, 'destroy']);

        /* المرتجعات */
        Route::get('/guest-return-orders', [\App\Http\Controllers\Api\guest\GuestOrdersController::class, 'returns']);
        Route::post('/guest-return-orders/store', [\App\Http\Controllers\Api\guest\GuestOrdersController::class, 'store']);
    });

    //
    ############################################ static pages ########################################

    Route::get('static-pages', [StaticPagesController::class, 'static_pages']);

    Route::get('common-questions', [StaticPagesController::class, 'common_questions']);
});


Route::get('/payment-page/{order_number}', [\App\Http\Controllers\Api\PaymentController::class, 'index'])->name('user.payment');
/*عملية الدفع*/
Route::get('/payment-page/{number}/payment/callback', [\App\Http\Controllers\Api\PaymentController::class, 'callback'])->name('payment.callback');
