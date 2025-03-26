<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Rule;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class AdminsController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('admin.view');
        $admins = $this->adminRepository->getAll();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('admin.create');
        $rules = Rule::all();
        //$adminRules = $admin->rules.blade.php()->pluck('id')->toArray();
        return view('dashboard.admins.create', \compact('rules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'new_password' => 'required|confirmed|min:6',
            'rules' => 'required|array'
        ]);

        $this->adminRepository->store($request->all());
        return to_route('admins.index')->with('success', __('messages.ADMIN_CREATED'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('admin.edit');

        $admin = Admin::findOrFail($id);
        $rules = Rule::all();
        $adminRules = $admin->rules()->pluck('id')->toArray();
        return view("dashboard.admins.edit", compact("admin", 'rules', 'adminRules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Gate::authorize('admin.edit');

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
            'rules' => 'required|array'
        ]);

        $this->adminRepository->update($data, $id);

        return to_route('admins.index')->with('success', __('messages.ADMIN_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('admin.delete');
        $this->adminRepository->delete($id);
        return back()->with('dark', __('messages.ADMIN_DELETED'));
    }

    public function ChangePassword(Request $request, $id)
    {
        Gate::authorize('admin.change_password');

        $request->validate([
            'new_password' => 'required|confirmed|min:6'
        ]);

        $data = $request->validate(['new_password' => 'required|confirmed|min:6']);
        $this->adminRepository->changePassword($id, $data);

        return back()->with('success', __('messages.ADMIN_UPDATE_PASSWORD'));
    }

    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to authenticate the admin
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // Redirect to admin dashboard
            return redirect()->route('dashboard.index');
        }

        // Authentication failed
        return back()->with('error', 'خطأ اثناء تسجيل الدخول');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
