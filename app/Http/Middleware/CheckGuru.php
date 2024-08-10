<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Guru;
use Symfony\Component\HttpFoundation\Response;

class CheckGuru
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $jenisGuru): Response
    {
        $user = Auth::user();

        // Assuming the 'guru' table has a user_id column that references the 'users' table
        $guru = Guru::where('id_user', $user->id)->first();

        if ($guru && $guru->jenis_guru == $jenisGuru) {
            return $next($request);
        }

        return redirect('/')->withErrors(['error' => 'You do not have permission to access this page.']);
    }
}
