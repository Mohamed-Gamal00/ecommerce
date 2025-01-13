<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Reports\ReportsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    protected $reportRepository;

    public function __construct(ReportsRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        $reportTitle = [
            'products-report' => 'تقرير المنتجات المتاحة',
            'return-products-report' => 'تقرير إرجاع الطلبات',
            'coupons-report' => 'تقرير كوبونات الخصم ',
            'customers-report' => 'تقرير عن العملاء الحاليين ',
            'shipping-report' => 'تقرير عن الشحن',
        ];
        $products = $this->reportRepository->getProductCartReport();

        return view('dashboard.reports.index', compact('products', 'reportTitle'));
    }

    public function ProductPage()
    {
        return view('dashboard.reports.product-report');
    }


    public function searchReport(Request $request)
    {
        $request->validate([
            'start_at' => 'nullable|',
            'end_at' => 'nullable|after:start_at'
        ]);
        $reportType = $request->report_type;
        $startAt = $request->start_at ?? '';
        $endAt = $request->end_at ?? '';
        $result = $this->reportRepository->searchReport($reportType, $startAt, $endAt);
        switch ($reportType) {
            case 'products-report':
                return view('dashboard.reports.product-report', ['products' => $result]);

            case 'customers-report':
                return view('dashboard.reports.clients-report', ['clients' => $result]);

            case 'coupons-report':
                return view('dashboard.reports.discountcode-report', ['discounts' => $result]);

            case 'return-products-report':
                return view('dashboard.reports.returnProducts-report', ['orders' => $result]);

            case 'shipping-report':
                return view('dashboard.reports.shipping-report', ['groupedOrders' => $result]);

            default:
                return redirect()->back()->with('error', 'Invalid report type.');
        }
    }
}
