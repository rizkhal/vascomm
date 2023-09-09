<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\Response;
use Illuminate\Http\Request;

class QueryUrlWhiteLists
{
    protected $whitelists = [
        'query',
        'take',
        'skip',
        'search',
        'perPage',
        'page',
        'limit',
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allParameters = $request->query();

        $filteredParameters = array_intersect_key($allParameters, array_flip($this->whitelists));

        $invalidParameters = array_diff_key($allParameters, $filteredParameters);

        if (!empty($invalidParameters)) {
            return Response::make(400, 'Invalid query parameters');
        }

        $request->replace(['query' => $filteredParameters]);

        return $next($request);
    }
}
