<?php

declare(strict_types=1);

namespace App\Psrphp\Theme\Psrphp;

use App\Psrphp\Admin\Http\Theme\Index;
use App\Psrphp\Admin\Model\MenuProvider;
use PsrPHP\Framework\App;
use PsrPHP\Framework\Config;
use PsrPHP\Framework\Framework;
use PsrPHP\Psr11\Container;
use PsrPHP\Template\Template;
use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    public function getListenersForEvent(object $event): iterable
    {
        if (is_a($event, Container::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    Container $container,
                ) {
                    $container->set(Template::class, function (
                        App $app,
                        Config $config,
                        Template $template,
                    ): Template {
                        $root = dirname(dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))));
                        foreach ($config->get('theme', []) as $key => $name) {
                            foreach ($app->all() as $vo) {
                                $template->addPath($vo['name'], $root . '/theme/' . $name . '/' . $vo['name'], 99 - $key);
                            }
                        }
                        return $template;
                    });
                }, [
                    Container::class => $event,
                ]);
            };
        }

        if (is_a($event, MenuProvider::class)) {
            yield function () use ($event) {
                Framework::execute(function (
                    MenuProvider $provider
                ) {
                    $provider->add('主题管理', Index::class);
                }, [
                    MenuProvider::class => $event,
                ]);
            };
        }
    }
}
