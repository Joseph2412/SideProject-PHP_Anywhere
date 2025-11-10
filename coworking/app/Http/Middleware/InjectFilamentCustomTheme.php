<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InjectFilamentCustomTheme
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Solo per le pagine di Filament
        if ($request->is('admin/*') || $request->is('host/*')) {
            $cssPath = storage_path('app/filament-custom-theme.css');
            
            if (File::exists($cssPath)) {
                $cssContent = File::get($cssPath);
                
                // Inject del CSS direttamente nell'HTML response
                $content = $response->getContent();
                $customStyle = "<style id='filament-custom-theme-direct'>\n{$cssContent}\n</style>";
                
                // Aggiungi prima del tag </head>
                $content = str_replace('</head>', $customStyle . "\n</head>", $content);
                $response->setContent($content);
            }
        }
        
        return $response;
    }
}