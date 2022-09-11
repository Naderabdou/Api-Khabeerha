<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UseApi
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
        if($request->api_key !== env('API_KEY','123456789')){
            return response()->json(['message'=>'you not allow to use this api']);
        }
        return $next($request);
    }
}
