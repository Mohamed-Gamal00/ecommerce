<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use App\Repositories\Rule\RuleRepository;
use Couchbase\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RulesController extends Controller
{
  protected $ruleRepository;

  public function __construct(RuleRepository $ruleRepository)
  {
    $this->ruleRepository = $ruleRepository;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //Gate::authorize('admin.group.view');
    $rules = $this->ruleRepository->getAll();
    return view('dashboard.admins.rules.index', compact('rules'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //Gate::authorize('admin.group.create');

    return view('dashboard.admins.rules.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //Gate::authorize('admin.group.create');

    $request->validate([
      'name' => 'required|string|max:255',
      'abilities' => 'required|array'
    ]);

    $this->ruleRepository->store($request);
    return to_route('rules.index')->with('success', __('messages.RULE_CREATED'));
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
  public function edit(Rule $rule)
  {
    //Gate::authorize('admin.group.edit');

    $rule_abilities = $rule->abilities()->pluck('type', 'ability')->toArray();

    return view('dashboard.admins.rules.edit', compact('rule', 'rule_abilities'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Rule $rule)
  {
    //Gate::authorize('admin.group.edit');

    if (!$request->input('abilities')) {
      return back()->with('info', 'برجاء تحديد صلاحية واحده على الاقل أو مسح المجموعة');
    }

    $request->validate([
      'name' => 'required|string|max:255',
      'abilities' => 'required|array'
    ]);

    $this->ruleRepository->update($request, $rule->id);

    return to_route('rules.index')->with('success', __('messages.RULE_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //Gate::authorize('admin.group.delete');

    $this->ruleRepository->delete($id);
    return to_route('rules.index')->with('dark', __('messages.RULE_DELETED'));
  }
}
