<?php

namespace App\Http\Middleware;

use App\Models\post;
use App\Models\user;
use Closure;
use Illuminate\Http\Request;

class communityrole
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
        if(post::where('postid', $request->postid)->first()->userid == $request->userid)
            return $next($request);
            return  response()->json('Cannot delete');
    }
}
