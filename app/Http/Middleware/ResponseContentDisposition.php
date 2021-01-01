<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class ResponseContentDisposition
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isJson()) {
            $this->clean($request->json());
        }

        return $next($request);
    }

    /**
     * Clean the request's data by removing mask from phonenumber.
     *
     * @param \Symfony\Component\HttpFoundation\ParameterBag $bag
     * @return void
     */
    private function clean(ParameterBag $bag)
    {
        $updates = $bag->get('updates');
        if (isset($updates[0]['payload']['params'][1][0]['name'])) {
            $updates[0]['payload']['params'][1][0]['name'] = str_replace('’', '', $updates[0]['payload']['params'][1][0]['name']);
            $bag->set('updates', $updates);
        }

    }
}
