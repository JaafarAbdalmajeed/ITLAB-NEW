<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventStaticFileConflict
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the request is for /css or /js (exact match), ensure it goes to routes
        $path = trim($request->path(), '/');
        
        // Check if this is a request for /css or /js (exact match, not a file)
        if ($path === 'css' || $path === 'js') {
            // Check if it's trying to access a static file
            $publicPath = public_path($path);
            
            // If it's a directory (like public/css or public/js), force route handling
            if (is_dir($publicPath)) {
                // Modify the request to ensure it goes through Laravel routing
                $request->server->set('REQUEST_URI', '/' . $path);
                $request->server->set('SCRIPT_NAME', '/index.php');
            }
        }
        
        return $next($request);
    }
}

