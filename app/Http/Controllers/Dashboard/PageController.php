<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Page\StaticPage;
use App\Models\Page;
use App\Repositories\Static_Pages\StaticPageRepository;
use Illuminate\Http\Request;

class PageController extends Controller
{
  protected $staticPageRepository;

  public function __construct(StaticPageRepository $Repo)
  {
    $this->staticPageRepository = $Repo;
  }
  /**
   * Display a listing of the resource.
   */
  // Add index method to list the pages
  public function index()
  {
    $pages = $this->staticPageRepository->getMainPages();
    return view('dashboard.static_pages.index', compact('pages'));
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
  public function edit($id)
  {
    $page = Page::findOrFail($id);
    return view('dashboard.static_pages.edit', compact('page'));
  }

  /**
   * Update the specified resource in storage.
   */
  // public function update(Request $request, $id)
  // {
  //   $request->validate([
  //     'title' => 'required|string|max:255',
  //     'content' => 'required|string',
  //   ]);

  //   $page = Page::findOrFail($id);
  //   $data = $request->only('title', 'content');
  //   // dd($data);

  //   $page->update($data);

  //   return redirect()->route('pages.index')
  //     ->with('success', 'تم التحديث بنجاح');
  // }
  public function update(StaticPage $request, $id)
  {
    $data = $request->validated();

    $wasChanged = $this->staticPageRepository->update($data, $id);

    if ($wasChanged) {
      return redirect()->route('pages.index')->with('success', __('messages.PAGE_UPDATED'));
    }

    return redirect()->route('pages.index')->with('dark', 'لم يتم التعديل لعدم وجود أي تغيير');
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
