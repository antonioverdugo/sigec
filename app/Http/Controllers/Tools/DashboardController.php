<?php

namespace App\Http\Controllers\Tools;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Poster;
use App\Models\Presentation;
use App\Models\Sponsor;
use Illuminate\View\View;

/**
 * Muestra el panel de administración con estadísticas del sistema.
 *
 * Recopila y retorna conteos de usuarios, presentaciones,
 * pósters y patrocinadores para ser mostrados en el dashboard.
 *
 * @return View Vista del dashboard con las estadísticas.
 *
 * @example GET /dashboard
 */
class DashboardController extends Controller
{
  public function index(): View
  {
    $users = [
      'total' => User::count(),
      'admin' => User::where('role_id', 3)->count(),
      'speaker' => User::where('role_id', 2)->count(),
      'assistant' => User::where('role_id', 1)->count(),
    ];
    $presentations = [
      'total' => Presentation::count(),
      'published' => Presentation::where('published', 1)->count(),
      'no-published' => Presentation::where('published', 0)->count(),
    ];
    $posters = [
      'total' => Poster::count(),
      'published' => Poster::where('published', 1)->count(),
      'no-published' => Poster::where('published', 0)->count(),
    ];
    $sponsors = [
      'total' => Sponsor::count(),
      'oro' => Sponsor::where('type_sponsor_id', 1)->count(),
      'plata' => Sponsor::where('type_sponsor_id', 2)->count(),
      'bronce' => Sponsor::where('type_sponsor_id', 3)->count(),
      'colaborador' => Sponsor::where('type_sponsor_id', 4)->count(),
      'institucional' => Sponsor::where('type_sponsor_id', 5)->count(),
    ];
    return view(
      'dashboard',
      compact(['users', 'presentations', 'posters', 'sponsors']),
    );
  }
}
