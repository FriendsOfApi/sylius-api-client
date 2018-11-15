<?php

declare(strict_types=1);

/*
 * This software may be modified and distributed under the terms
 * of the MIT license. See the LICENSE file for details.
 */

namespace FAPI\Sylius\tests;

use FAPI\Sylius\Http\ClientConfigurator;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Nyholm\NSA;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HttpClientConfiguratorTest extends TestCase
{
    public function testAppendPlugin()
    {
        $hcc = new ClientConfigurator();
        $plugin0 = new HeaderAppendPlugin(['plugin0']);

        $hcc->appendPlugin($plugin0);
        $plugins = NSA::getProperty($hcc, 'appendPlugins');
        static::assertCount(1, $plugins);
        static::assertEquals($plugin0, $plugins[0]);

        $plugin1 = new HeaderAppendPlugin(['plugin1']);
        $hcc->appendPlugin($plugin1);
        $plugins = NSA::getProperty($hcc, 'appendPlugins');
        static::assertCount(2, $plugins);
        static::assertEquals($plugin1, $plugins[1]);
    }

    public function testAppendPluginMultiple()
    {
        $hcc = new ClientConfigurator();
        $plugin0 = new HeaderAppendPlugin(['plugin0']);
        $plugin1 = new HeaderAppendPlugin(['plugin1']);

        $hcc->appendPlugin($plugin0, $plugin1);
        $plugins = NSA::getProperty($hcc, 'appendPlugins');
        static::assertCount(2, $plugins);
        static::assertEquals($plugin0, $plugins[0]);
        static::assertEquals($plugin1, $plugins[1]);
    }

    public function testPrependPlugin()
    {
        $hcc = new ClientConfigurator();
        $plugin0 = new HeaderAppendPlugin(['plugin0']);

        $hcc->prependPlugin($plugin0);
        $plugins = NSA::getProperty($hcc, 'prependPlugins');
        static::assertCount(1, $plugins);
        static::assertEquals($plugin0, $plugins[0]);

        $plugin1 = new HeaderAppendPlugin(['plugin1']);
        $hcc->prependPlugin($plugin1);
        $plugins = NSA::getProperty($hcc, 'prependPlugins');
        static::assertCount(2, $plugins);
        static::assertEquals($plugin1, $plugins[0]);
    }

    public function testPrependPluginMultiple()
    {
        $hcc = new ClientConfigurator();
        $plugin0 = new HeaderAppendPlugin(['plugin0']);
        $plugin1 = new HeaderAppendPlugin(['plugin1']);

        $hcc->prependPlugin($plugin0, $plugin1);
        $plugins = NSA::getProperty($hcc, 'prependPlugins');
        static::assertCount(2, $plugins);
        static::assertEquals($plugin0, $plugins[0]);
        static::assertEquals($plugin1, $plugins[1]);
    }
}
