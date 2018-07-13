<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Request;

class InProcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $base = '/research/';

        //URLs autorises
        $allowed = [$base.'protocol', $base.'center', $base.'patient', $base.'cid',
                    $base.'food', $base.'biochemistry', $base.'analyse', $base.'select-gene', $base.'results'];

        //Si la demande n'est pas saisie directement dans l'url
        //sinon redirection vers la page d'accueil
        if(Request::server('HTTP_REFERER')){
            $referer = str_replace(url('/'), '', Request::server('HTTP_REFERER'));

            //si le referer ne fait pas partie des autorisations alors redirection
            //en page d'accueil
            if(!array_keys($allowed, $referer)){
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('home');
        }

        return $next($request);
    }
}
