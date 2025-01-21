<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\CommonQuestion;
use App\Models\Page;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function static_pages()
    {
        $page = Page::select('title', 'content')->where('id', '3')->first();

        if ($page) {
            $page->content = translateWithHTMLTags($page->content);
            $page->title = translateWithHTMLTags($page->title);
        }

        $shipping_policy = Page::select('title', 'content')->where('id', '2')->first();
        if ($shipping_policy) {
            $shipping_policy->content = translateWithHTMLTags($shipping_policy->content);
            $shipping_policy->title = translateWithHTMLTags($shipping_policy->title);
        }

        $Terms_and_Conditions = Page::select('title', 'content')->where('id', '1')->first();
        if ($Terms_and_Conditions) {
            $Terms_and_Conditions->content = translateWithHTMLTags($Terms_and_Conditions->content);
            $Terms_and_Conditions->title = translateWithHTMLTags($Terms_and_Conditions->title);

        }

        $data = [$page, $shipping_policy, $Terms_and_Conditions];
        if ($page) {
            return ApiResponse::sendResponse(200, 'data Retrieved Successfully', $data);
        } else {
            return ApiResponse::sendResponse(200, 'data not found');
        }
    }

    public function common_questions()
    {
        $questions = CommonQuestion::select('title', 'description')->get();

        if ($questions->isEmpty()) {
            return ApiResponse::sendResponse(200, 'Data not found');
        }

        // Translate each question's title and description
        $questions = $questions->map(function ($question) {
            $question->title = translateWithHTMLTags($question->title);
            $question->description = translateWithHTMLTags($question->description);
            return $question;
        });

        return ApiResponse::sendResponse(200, 'Data Retrieved Successfully', $questions);
    }

}
