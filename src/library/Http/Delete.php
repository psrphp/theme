<?php

declare(strict_types=1);

namespace App\Psrphp\Theme\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Dir;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Framework\Config;
use PsrPHP\Request\Request;
use PsrPHP\Router\Router;

class Delete extends Common
{
    public function post(
        Config $config,
        Router $router,
        Request $request,
    ) {
        $name = $request->post('name');

        if (!preg_match('/^[a-zA-Z0-9]+$/u', $name)) {
            return Response::error('参数错误！');
        }

        $root = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));
        Dir::del($root . '/theme/' . $name);

        $theme = $config->get('theme', []);
        $key = array_search($name, $theme);
        if ($key !== false) {
            unset($theme[$key]);
        }
        $config->save('theme', array_values($theme));

        return Response::redirect($router->build('/psrphp/theme/index'));
    }
}
