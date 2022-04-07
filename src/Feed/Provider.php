<?php

namespace App\Feed;

use Debril\RssAtomBundle\Provider\FeedProviderInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use FeedIo\Feed;
use FeedIo\Feed\Item;
use FeedIo\FeedInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class Provider implements FeedProviderInterface
{
    protected $logger;

    protected $registry;

    protected $router;
    private $em;

    /**
     * Provider constructor.
     */
    public function __construct(LoggerInterface $logger, Registry $registry, Router $router, EntityManagerInterface $em)
    {
        $this->logger = $logger;
        $this->registry = $registry;
        $this->router = $router;
        $this->em = $em;
    }

    public function getFeed(Request $request): FeedInterface
    {
        // build the feed the way you want
        $feed = new Feed();
        $feed->setTitle('My feed');
        foreach ($this->getItems() as $item) {
            $feed->add($item);
        }

        return $feed;
    }

    protected function getItems()
    {
        foreach ($this->fetchFromStorage() as $storedItem) {
            $item = new Item();
            $item->setTitle($storedItem['title']);
            $item->setDescription($storedItem['description']);
            $item->setLastModified(new \DateTime());
            // ...
            yield $item;
        }
    }

    protected function fetchFromStorage()
    {
        for ($i = 0; $i < 11; ++$i) {
            $content = [
              'title' => 'title'.$i,
              'description' => 'description'.$i,
            ];
            yield $content;
        }
    }
}
