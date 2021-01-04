<?php

namespace App\Http\Middleware;

use App\Models\Access;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use app\Tools\Visit;

class AccessInfo extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data['access_url'] = $request->url();
        $data['ip'] = $request->ip();
        $data['browser'] = Visit::GetBrowser();
        $data['os'] = Visit::GetOS();
        $data['lang'] = Visit::GetLang();
        $data['start_time'] = time();
        $data['end_time'] = time();
        Access::create($data);
        return $next($request);
    }
}
