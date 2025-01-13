<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CommonQuestion\CommonQuestionRequest;
use App\Models\CommonQuestion;
use App\Repositories\common_questions\CommonQuestionsRepository;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
  protected $commonQuestions;

  public function __construct(CommonQuestionsRepository $commonQuestions)
  {
    $this->commonQuestions = $commonQuestions;
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $questions = $this->commonQuestions->getMainCommon_questions();
    return view('dashboard.common_questions.index', compact('questions'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('dashboard.common_questions.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(CommonQuestionRequest $request)
  {

    $data = $request->validated();

    $this->commonQuestions->store($data);

    return redirect()->route('common_questions.index')
      ->with('success', __('messages.QUESTION_CREATED'));
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
  public function edit(CommonQuestion $commonQuestion)
  {
    return view('dashboard.common_questions.edit', compact('commonQuestion'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(CommonQuestionRequest $request, $id)
  {
    $data = $request->validated();

    $this->commonQuestions->update($data, $id);

    return redirect()->route('common_questions.index')
      ->with('success', __('messages.QUESTION_UPDATED'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $this->commonQuestions->delete($id);

    return redirect()->route('common_questions.index')
      ->with('success', __('messages.QUESTION_DELETED'));
  }
}
