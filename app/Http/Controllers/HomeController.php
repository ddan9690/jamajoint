<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $exams = Exam::orderBy('created_at', 'desc')->get();
        return view('backend.index', compact('exams'));
    }

    public function news()
    {
        $news = News::latest()->get();

        return view('frontend.news', compact('news'));
    }
}
