<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Page;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{
    /**
     * PagesController constructor.
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
        Session::flash('sidebar', 'pages');

        $pages = Page::all();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        Session::flash('sidebar', 'pages');

        return view('admin.pages.create');
    }

    /**
     * @param CreatePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreatePageRequest $request)
    {
        Page::create(['name' => $request->name, 'title' => $request->title, 'content' => $request->page_content, 'sticky' => $request->sticky, 'sticky_date' => $request->sticky_date, 'page_type' => $request->page_type]);

        return redirect()->back()->with(['success' => 'page created successfully!']);
    }

    /**
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Page $page)
    {
        Session::flash('sidebar', 'pages');

        return view('admin.pages.update', compact('page'));
    }

    /**
     * @param Page $page
     * @param UpdatePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Page $page, UpdatePageRequest $request)
    {

	    $page->update(['name' => $request->name, 'title' => $request->title, 'content' => $request->page_content, 'sticky' => $request->sticky, 'sticky_date' => $request->sticky_date, 'page_type' => $request->page_type]);

        return redirect()->back()->with(['success' => 'page updated successfully!']);
    }

    /**
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->back()->with(['success' => 'page deleted successfully!']);
    }
}
