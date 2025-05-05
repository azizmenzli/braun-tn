<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\VisitorLog;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;           
class TrafficController extends Controller{
public function index()
{
      // Visiteurs d'aujourd'hui
      $todayVisitors = VisitorLog::whereDate('visit_time', now()->toDateString())->count();

      // Visiteurs d'hier
      $yesterdayVisitors = VisitorLog::whereDate('visit_time', now()->subDay()->toDateString())->count();

      // Pages les plus visitées (Top 10)
      $mostVisitedPages = VisitorLog::select('visited_page', \DB::raw('COUNT(*) as visits'))
          ->groupBy('visited_page')
          ->orderBy('visits', 'desc')
          ->limit(10)
          ->get();

      // Systèmes d'exploitation les plus utilisés
      $topOS = VisitorLog::select('os', \DB::raw('COUNT(*) as count'))
          ->groupBy('os')
          ->orderBy('count', 'desc')
          ->get();

      // Visiteurs en ligne (moins de 5 minutes)
      $onlineVisitors = VisitorLog::where('visit_time', '>=', now()->subMinutes(5))->count();

      // Retourner la vue avec les données collectées
      return view('dashboard.traffic', compact(
          'todayVisitors', 'yesterdayVisitors', 'mostVisitedPages', 'topOS', 'onlineVisitors'
      ));
  }
}
