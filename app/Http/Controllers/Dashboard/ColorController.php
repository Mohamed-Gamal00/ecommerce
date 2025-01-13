<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Colors\ColorRequest;
use App\Models\Color;
use App\Repositories\Color\ColorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ColorController extends Controller
{
  public $colorRepo;
  public function __construct(ColorRepository $repo)
  {
    $this->colorRepo = $repo;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('color.view');

    // $colors = Color::paginate();
    $colors = $this->colorRepo->getMainColor();
    return view('dashboard.colors.index', \compact('colors'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('color.create');

    return view('dashboard.colors.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ColorRequest $request)
  {
    //Gate::authorize('color.create');
    $data = $request->validated();
    $this->colorRepo->store($data);
    return \to_route('colors.index')->with('success', __('messages.COLOR_CREATED'));
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
    //Gate::authorize('color.edit');

    $color = Color::findOrFail($id);
    return view('dashboard.colors.edit', \compact('color'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ColorRequest $request, string $id)
  {
    //Gate::authorize('color.edit');
    $data = $request->validated();
    $this->colorRepo->update($data, $id);

    return \to_route('colors.index')->with('success', __('messages.COLOR_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('color.delete');
    $this->colorRepo->delete($id);
    return back()->with('dark', __('messages.COLOR_DELETED'));
  }
}
