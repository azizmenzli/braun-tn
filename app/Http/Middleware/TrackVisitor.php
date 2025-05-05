<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GeoIp2\Database\Reader; // Correct import statement
use Jenssegers\Agent\Agent;
use App\Models\VisitorLog;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Capturer l'IP de l'utilisateur
        $ipAddress = $request->ip();

        // Utilisation de GeoIP pour obtenir la localisation
        try {
            $reader = new Reader(base_path('database/geoip/GeoLite2-City.mmdb')); // Correct path to the GeoIP database
            $geoData = $reader->city($ipAddress);  // Fetch city data using the city() method

            $country = $geoData->country->name ?? 'Unknown'; // Safe access to country name
            $city = $geoData->city->name ?? 'Unknown'; // Safe access to city name
            $latitude = $geoData->location->latitude ?? 0; // Safe access to latitude
            $longitude = $geoData->location->longitude ?? 0; // Safe access to longitude
        } catch (\Exception $e) {
            // Handle GeoIP retrieval errors gracefully
            $country = $city = 'Unknown';
            $latitude = $longitude = 0;
        }

        // Récupérer les informations de l'agent utilisateur (navigateur, OS, etc.)
        $agent = new Agent();
        $agent->setUserAgent($request->header('User-Agent'));

        // Récupérer la page actuelle visitée
        $visitedPage = $request->path();

        // Sauvegarder les données dans la base de données
        VisitorLog::create([
            'ip_address' => $ipAddress,
            'country' => $country,
            'city' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'os' => $agent->platform(),
            'browser' => $agent->browser(),
            'device' => $agent->device(),
            'referer' => $request->headers->get('referer'),
            'visited_page' => $visitedPage,
            'visit_time' => now(),
        ]);

        return $next($request);
    }
}
