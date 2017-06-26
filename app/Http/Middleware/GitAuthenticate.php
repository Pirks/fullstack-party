<?php

namespace App\Http\Middleware;

use Closure;
use App\Components\Github\GithubInterface;
use App\Components\Github\GithubException;

class GitAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session(config('github.token_key'))) {
            return redirect(route('git.login'));
        }
        
        // Check if token is valid and log out if not
        try {
            app(GithubInterface::class)->getUser(session(config('github.token_key')));
        } catch (GithubException $exc) {
            return redirect(route('git.logout'));
        }
        
        return $next($request);
    }
}
