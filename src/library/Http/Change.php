<?php

declare(strict_types=1);

namespace App\Psrphp\Theme\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Response;
use PsrPHP\Request\Request;
use PsrPHP\Framework\Config;

class Change extends Common
{

    public function post(
        Request $request,
        Config $config
    ) {
        $name = $request->post('name');

        if (!preg_match('/^[a-zA-Z0-9]+$/u', $name)) {
            return Response::error('参数错误！');
        }

        $theme = $config->get('theme', []);
        $theme['name'] = $name == $theme['name'] ? '' : $name;

        $config->save('theme', $theme);

        return Response::success('操作成功！');
    }
}
