<?php

namespace App\Repositories\Reports;

use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportsRepository implements ReportInterface
{
  public function getProductCartReport()
  {
    return Product::withCount([
      'cartItemsWithoutScope as cart_count' => function ($query) {
        $query->select(DB::raw('count(*)'));
      },
      'orderItems as order_count' => function ($query) {
        $query->select(DB::raw('count(*)'));
      }
    ])->latest()
      ->withoutTrashed()
      ->paginate();
  }

  public function SearchReport($reportType, $startAt, $endAt)
  {

    switch ($reportType) {
        //products-report
      case 'products-report':
        $query = Product::latest()->with(['availability'])
          ->where('status', 'active')
          ->whereHas('availability', function ($query) {
            $query->where('name', 'جديد')->orWhere('name', 'لفتره محدوده');
          });

        if ($startAt && $endAt) {
          $query->whereBetween('created_at', [$startAt, $endAt]);
        }

        return $query->paginate();


      case 'customers-report':
        $query = User::with('addresses.country')->latest();

        if ($startAt && $endAt) {
          $query->whereBetween('created_at', [$startAt, $endAt]);
        }

        return $query->get();


      case 'coupons-report':
        $query = DiscountCode::latest();

        if ($startAt && $endAt) {
          $query->whereBetween('created_at', [$startAt, $endAt]);
        }

        return $query->get();


      case 'return-products-report':
        $query = Order::where('return_order', true)->with('orderItems');

        if ($startAt && $endAt) {
          $query->whereBetween('created_at', [$startAt, $endAt]);
        }

        return $query->get()
          ->flatMap(function ($order) {
            return $order->orderItems;
          })
          ->groupBy('product_id')
          ->map(function ($items) {
            return [
              'product' => $items->first()->product,
              'total_returned' => $items->sum('quantity')
            ];
          });



      case 'shipping-report':
        $query = Order::whereHas('orderStatus', function ($query) {
          $query->where('name', 'تم التوصيل');
        })->with('orderItems');

        if ($startAt && $endAt) {
          $query->whereBetween('updated_at', [$startAt, $endAt]);
        }

        return $query->get()
          ->flatMap(function ($order) {
            return $order->orderItems->map(function ($orderItem) use ($order) {
              $orderItem->shipping_date = $order->updated_at;
              return $orderItem;
            });
          })
          ->groupBy('product_id')
          ->map(function ($items) {
            return [
              'product' => $items->first()->product,
              'total_shipped' => $items->sum('quantity'),
              'shipping_dates' => $items->pluck('shipping_date'),
            ];
          });

      default:
        return [];
    }
  }
}
