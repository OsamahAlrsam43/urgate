<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\News;
use Illuminate\Support\Facades\Session;

class NewsController extends Controller
{

    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'dashboardAccess']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Session::flash('sidebar', 'news');

        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'news');

        return view('admin.news.create');
    }

    /**
     * @param CreateNewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateNewsRequest $request)
    {
        News::create(['content' => $request->news]);

        return redirect()->back()->with(['success' => 'news created successfully!']);
    }

    /**
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(News $news)
    {
        Session::flash('sidebar', 'news');

        return view('admin.news.update', compact('news'));
    }

    /**
     * @param News $news
     * @param UpdateNewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(News $news, UpdateNewsRequest $request)
    {
        $news->update(['content' => $request->news]);

        return redirect()->back()->with(['success' => 'news updated successfully!']);
    }

    /**
     * @param News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->back()->with(['success' => 'news deleted successfully!']);
    }
}
