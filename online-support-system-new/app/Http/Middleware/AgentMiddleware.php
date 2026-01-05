<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('agent.login')->with('error', 'Please login first.');
        }

        if (Auth::user()->role !== 'agent') {
            Auth::logout();
            return redirect()->route('agent.login')->with('error', 'Access denied. Agent access only.');
        }

        return $next($request);
    }
}
