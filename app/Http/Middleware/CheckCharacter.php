<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCharacter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $character = $request->user()->currentCharacter();
        if (!$character) {
            return redirect()->route('characters.create')->with('error', 'Нужен персонаж');
        }
        $character->setActivityAt();

        return $next($request);
    }
}
