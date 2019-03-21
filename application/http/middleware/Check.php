<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        if (!\Session::has('admin_id')) {
            return \redirect('index/login/login')->remember();
        } else {
            return $next($request);
        }
    }
}
