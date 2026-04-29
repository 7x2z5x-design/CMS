<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Editor');
    }

    /**
     * Show editor dashboard.
     */
    public function dashboard()
    {
        return view('editor.dashboard');
    }

    /**
     * Show editor preferences.
     */
    public function preferences()
    {
        return view('editor.preferences');
    }

    /**
     * Show scheduled content.
     */
    public function scheduled()
    {
        return view('editor.scheduled.index');
    }

    /**
     * Show drafts.
     */
    public function drafts()
    {
        return view('editor.drafts.index');
    }

    /**
     * Show reviews.
     */
    public function reviews()
    {
        return view('editor.reviews.index');
    }

    /**
     * Show approved content.
     */
    public function approved()
    {
        return view('editor.approved.index');
    }

    /**
     * Show rejected content.
     */
    public function rejected()
    {
        return view('editor.rejected.index');
    }

    /**
     * Show analytics.
     */
    public function analytics()
    {
        return view('editor.analytics');
    }

    /**
     * Show reports.
     */
    public function reports()
    {
        return view('editor.reports.index');
    }

    /**
     * Show engagement metrics.
     */
    public function engagement()
    {
        return view('editor.engagement.index');
    }

    /**
     * Show SEO tools.
     */
    public function seo()
    {
        return view('editor.seo.index');
    }

    /**
     * Show keywords management.
     */
    public function keywords()
    {
        return view('editor.keywords.index');
    }

    /**
     * Show import tools.
     */
    public function import()
    {
        return view('editor.import.index');
    }

    /**
     * Show export tools.
     */
    public function export()
    {
        return view('editor.export.index');
    }

    /**
     * Show backup management.
     */
    public function backup()
    {
        return view('editor.backup.index');
    }
}
