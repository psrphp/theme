<?php

declare(strict_types=1);

namespace App\Psrphp\Theme\Http;

use App\Psrphp\Admin\Http\Common;
use Composer\InstalledVersions;
use PsrPHP\Template\Template;
use ReflectionClass;

class Index extends Common
{
    public function get(
        Template $template
    ) {

        $themes = [];
        $root = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName())));

        foreach (glob($root . '/theme/*/config.json') as $file) {
            $name = substr($file, strlen($root . '/theme/'), -strlen('/config.json'));
            $json = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
            $thumb_file = $root . '/theme/' . $name . '/thumb.jpg';
            $json['thumb'] = file_exists($thumb_file) ? ('data:image/jpeg;base64,' . base64_encode(file_get_contents($thumb_file))) : $this->getDefaultThumb();
            $json['name'] = $name;
            $themes[$name] = $json;
        }

        return $template->renderFromFile('index@psrphp/theme', [
            'themes' => $themes,
        ]);
    }

    private function getDefaultThumb(): string
    {
        return 'data:image/svg+xml;base64,' . base64_encode('<svg class="icon" style="width: 1em;height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5113"><path d="M0 0h1024v1024H0V0z" fill="#F5F5F5" p-id="5114"></path><path d="M657.066667 574.577778l-8.533334 17.066666c48.355556 8.533333 93.866667 22.755556 139.377778 39.822223l8.533333-17.066667c-45.511111-17.066667-93.866667-31.288889-139.377777-39.822222z m-167.822223-79.644445c2.844444 0 2.844444 0 2.844445-2.844444v-19.911111c0-2.844444-2.844444-2.844444-2.844445-2.844445h-164.977777c5.688889-28.444444 8.533333-59.733333 8.533333-88.177777H466.488889c2.844444 0 2.844444-2.844444 2.844444-2.844445v-17.066667c0-2.844444-2.844444-2.844444-2.844444-2.844444H179.2c-2.844444 0-2.844444 0-2.844444 2.844444v17.066667c0 2.844444 0 2.844444 2.844444 2.844445h128c0 28.444444-2.844444 59.733333-8.533333 88.177777h-142.222223c-2.844444 0-2.844444 2.844444-2.844444 2.844445v19.911111c0 2.844444 0 2.844444 2.844444 2.844444h139.377778c-5.688889 19.911111-11.377778 36.977778-22.755555 56.888889-11.377778 22.755556-28.444444 45.511111-45.511111 62.577778-22.755556 22.755556-51.2 39.822222-79.644445 51.2 5.688889 2.844444 11.377778 8.533333 17.066667 14.222222 0 0 2.844444 2.844444 5.688889 2.844445s2.844444 0 5.688889-2.844445c25.6-14.222222 48.355556-31.288889 68.266666-48.355555 19.911111-19.911111 39.822222-45.511111 51.2-71.111111 11.377778-19.911111 19.911111-42.666667 22.755556-65.422223h170.666666z" fill="#CCCCCC" p-id="5115"></path><path d="M494.933333 605.866667c-2.844444-2.844444-2.844444-2.844444-5.688889-2.844445l-17.066666-8.533333c2.844444 17.066667-2.844444 36.977778-11.377778 51.2-17.066667 8.533333-34.133333 11.377778-54.044444 8.533333-17.066667 2.844444-34.133333 0-48.355556-5.688889-5.688889-8.533333-5.688889-17.066667-5.688889-25.6v-65.422222c0-11.377778 0-19.911111 2.844445-31.288889 0-2.844444 2.844444-5.688889 2.844444-8.533333 0-2.844444-2.844444-2.844444-5.688889-2.844445-8.533333 0-19.911111-2.844444-28.444444-2.844444 2.844444 14.222222 2.844444 28.444444 2.844444 42.666667v73.955555c0 8.533333 0 17.066667 2.844445 25.6 0 5.688889 2.844444 8.533333 8.533333 14.222222l17.066667 8.533334c17.066667 2.844444 31.288889 2.844444 48.355555 2.844444 25.6 2.844444 51.2-2.844444 73.955556-14.222222 11.377778-14.222222 19.911111-34.133333 19.911111-51.2v-2.844444c0-2.844444 0-5.688889-2.844445-5.688889z m71.111111-264.533334v338.488889h19.911112v-22.755555h270.222222v22.755555h19.911111V341.333333H566.044444z m290.133334 295.822223h-270.222222v-275.911112h270.222222v275.911112z" fill="#CCCCCC" p-id="5116"></path><path d="M685.511111 526.222222l-8.533333 17.066667c36.977778 8.533333 73.955556 19.911111 110.933333 36.977778l8.533333-17.066667c-34.133333-14.222222-71.111111-28.444444-110.933333-36.977778z" fill="#CCCCCC" p-id="5117"></path><path d="M603.022222 540.444444c42.666667-8.533333 82.488889-22.755556 119.466667-42.666666 36.977778 22.755556 76.8 36.977778 119.466667 42.666666l8.533333-17.066666c-36.977778-5.688889-73.955556-19.911111-108.088889-36.977778 25.6-19.911111 48.355556-42.666667 68.266667-68.266667v-17.066666h-119.466667l19.911111-25.6-17.066667-8.533334c-25.6 34.133333-54.044444 62.577778-88.177777 88.177778l14.222222 14.222222c14.222222-8.533333 25.6-19.911111 36.977778-31.288889 14.222222 19.911111 34.133333 34.133333 54.044444 48.355556-34.133333 17.066667-73.955556 31.288889-110.933333 36.977778l2.844444 17.066666z m62.577778-116.622222l5.688889-5.688889h113.777778c-17.066667 22.755556-36.977778 42.666667-62.577778 56.888889-19.911111-14.222222-39.822222-31.288889-56.888889-51.2z" fill="#CCCCCC" p-id="5118"></path></svg>');
    }
}
