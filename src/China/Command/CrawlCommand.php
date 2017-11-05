<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Command;

use China\Common\FilesystemAwareInterface;
use China\Common\FilesystemAwareTrait;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Filesystem\Filesystem;

class CrawlCommand extends Command implements CrawlerAwareInterface, FilesystemAwareInterface
{
    use FilesystemAwareTrait;

    /**
     * @var Client
     */
    protected static $client;

    /**
     * 资源目录
     * @var string
     */
    const RESOURCE_DIR = __DIR__ . '/../../../resources/';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        parent::__construct(null);
    }

    /**
     * {@inheritdoc}
     */
    public function getClient()
    {
        if (static::$client) {
            return static::$client;
        }
        static::$client = new Client();
        $guzzleClient = new GuzzleClient([
            'timeout' => 60,
            'verify' => false
        ]);
        static::$client->setClient($guzzleClient);
        return static::$client;
    }
}