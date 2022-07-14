<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sessiondata = DB::table('sessions')->orderBy('id', 'DESC')->first();
        if ($sessiondata)
            session(['session_date' => $sessiondata->session_date, 'session_term' => $sessiondata->session_term]);
        else
            session(['session_date' => "No", 'session_term' => "No"]);
        return $next($request);
    }
}
