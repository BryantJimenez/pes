<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $users=User::with(['users.user.users.user.users'])->role('Coordinador de Ruta')->get();
        return view('admin.reports.index', compact('users'));
    }
}
