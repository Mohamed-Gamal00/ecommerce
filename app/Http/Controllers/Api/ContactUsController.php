<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Requests\Api\ContactUsRequest;
use App\Models\Admin;
use App\Models\ContactUs;
use App\Notifications\ContactFormSubmitted;
use App\Notifications\NewMessageEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;


class ContactUsController extends Controller
{
    public function sendMessage(ContactUsRequest $request)
    {
        $request->validated();
        $form = ContactUs::create([
            'name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'message' => $request->message
        ]);

        $admins = Admin::all();

        if ($form) {
            Notification::send($admins, new ContactFormSubmitted($form));

            foreach ($admins as $admin) {
                try {
                    if (filter_var($admin->email, FILTER_VALIDATE_EMAIL)) {
                        Notification::send($admin, new NewMessageEmail($form));
                    } else {
                        \Log::warning('Invalid email address: ' . $admin->email);
                    }
                } catch (\Exception $e) {
                    \Log::error('Error sending email to admin ' . $admin->email . ': ' . $e->getMessage());
                }
            }
            return ApiResponse::sendResponse(200, 'Message Sent Successfully', []);
        }
        return ApiResponse::sendResponse(200, 'Cannot Send Message', []);
    }
}
