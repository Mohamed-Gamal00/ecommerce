<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChoiceController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $choices = Choice::latest()->paginate();
    return view('dashboard.choices.index', compact('choices'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $mainChoices = Choice::latest()->paginate();
    return view('dashboard.choices.create', compact('mainChoices'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $data = $request->validate([
      'name' => 'required|string|max:255',
    ]);
    // dd($data);
    if ($request->input('type') == 'sub') {
      $validated = $request->validate([
        'parent_id' => ['required', 'exists:choices,id'],
      ]);
      $data['parent_id'] = $validated['parent_id'];
      // dd($data);
    } else {
      $data['parent_id'] = null;
    }
    // dd($data);

    DB::transaction(function () use ($data) {
      Choice::create($data);
    });
    return redirect()->route('main_choices.index')
      ->with('success', __('messages.MAIN_CHOICE_CREATED'));
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
    $choice = Choice::findOrFail($id);
    $mainChoices = Choice::where('id', '!=', $id)->get();;
    return view('dashboard.choices.edit', compact('choice', 'mainChoices'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $category = Choice::findOrFail($id);

    $data = $request->validate([
      'name' => 'required|string|max:255',
    ]);

    if ($request->input('type') == 'sub') {
      $validated = $request->validate([
        'parent_id' => ['required', 'exists:choices,id'],
      ]);
      $data['parent_id'] = $validated['parent_id'];
    } else {
      $data['parent_id'] = null;
    }
    // dd($data);
    DB::transaction(function () use ($category, $data) {
      $category->update($data);
    });
    return redirect()->route('main_choices.index')
      ->with('success', __('messages.MAIN_CHOICE_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $category = Choice::findOrFail($id);
    $category->delete();
    return back()
      ->with('dark', __('messages.MAIN_CHOICE_DELETED'));
  }
}
