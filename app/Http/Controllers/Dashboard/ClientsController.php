<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Client\ClientRequest;
use App\Http\Requests\Dashboard\Client\ClientUpdatePasswordRequest;
use App\Models\User;
use App\Repositories\Client\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ClientsController extends Controller
{

  public $clientRepo;
  public function __construct(ClientRepository $repo)
  {
    $this->clientRepo = $repo;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('client.view');
    // $clients = User::with('addresses.country')->latest()->paginate();
    $clients = $this->clientRepo->getMainClient();
    // dd($clients);

    return view('dashboard.clients.index', compact('clients'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
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
    //Gate::authorize('client.change_password');
    $client = User::findOrFail($id);
    return view('dashboard.clients.edit', compact('client'));
  }


  public function updatePassword(ClientUpdatePasswordRequest $request, string $id)
  {
    //Gate::authorize('client.change_password');
    $data = $request->validated();
    $this->clientRepo->updatePassword($data, $id);
    return back()->with('success', __('messages.CLIENT_UPDATED_PASSWORD'));
  }

  public function update(ClientRequest $request, string $id)
  {
    //Gate::authorize('client.edit');

    $data = $request->validated();

    $wasChanged = $this->clientRepo->update($data, $id);

    if ($wasChanged) {
      return redirect()->back()->with('success', __('messages.CLIENT_UPDATED'));
    }
    return redirect()->back()->with('dark', __('messages.CLIENT_NOT_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('client.delete');

    $this->clientRepo->delete($id);
    return back()->with('dark', __('messages.CLIENT_DELETE'));
  }
}
