<?php

   namespace App\Http\Controllers;

   use App\currency\Currency;
   use App\Http\Middleware\Admin;
   use App\Models\ContactUs;
   use App\Models\Order;
   use App\Models\Product;
   use App\Models\Setting;
   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Storage;

   class DashboardController extends Controller
   {
      public function index()
      {
         $productsCount = Product::count();
         $ordersCount = Order::count();
         $usersCount = User::count();
         $messagesCount = ContactUs::count();
         $adminsCount = \App\Models\Admin::count();
         $mainCurrency = DB::table('currencies')->select('name_ar')->where('default_currency', true)->first();
         return view('dashboard.dashboard', \compact('productsCount', 'ordersCount', 'mainCurrency', 'usersCount', 'adminsCount', 'messagesCount'));
      }
   }
