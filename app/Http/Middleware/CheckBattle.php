<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBattle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $character = $request->user()->currentCharacter();

        $battle = $character->openBattle();

        if ($battle) {
            return redirect()->route('battles.show', $battle)->with('error', 'У вас есть откытый бой');
        }

        return $next($request);
    }
}
