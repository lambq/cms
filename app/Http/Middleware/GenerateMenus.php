<?php

namespace App\Http\Middleware;

use Closure;

class GenerateMenus
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
        \Menu::make('MyNavBar', function ($menu) {
            $menus = \App\menu::where('hide',0)->get();
            foreach ($menus as $v) {
                $menu->add($v->title,$v->name);
            }
        });
        return $next($request);
    }
}
