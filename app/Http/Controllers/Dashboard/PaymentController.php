<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{

    public function index()
    {
        $token = base64_encode(config('services.moyasar.secret') . ':');

        $response = Http::baseUrl('https://api.moyasar.com/v1')
            ->withHeaders([
                'Authorization' => "Basic {$token}",
            ])
            ->get('payments'); // This fetches all payments

        $data = $response->json()['payments']; // Get the payments array from the response
        $payments = $this->paginate($data, 15); // Set 15 items per page

        return view('dashboard.payments.payments', compact('payments'));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $path = request()->url(); // Get the current URL
        $options['path'] = $path; // Set the correct path for pagination links

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
