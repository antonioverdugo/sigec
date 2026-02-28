<?php

namespace App\Http\Controllers\Tools;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
  public function index(): View
  {
    $countUser = User::count();
    return view('dashboard', compact('countUser'));
  }
}
