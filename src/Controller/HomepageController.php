<?php

namespace App\Controller;

use FeedIo\Feed;
use FeedIo\FeedIo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/read", name="app_homepage")
     * @throws \Exception
     */
    public function readFeed(FeedIo $feedIo)
    {
        $date = '2022-01-01';
        // this date is used to fetch only the latest items
        $modifiedSince = new \DateTime($date);

        // the feed you want to read
        $url = 'https://feeds.feedburner.com/symfony/blog';

        // now fetch its (fresh) content
        $feed = $feedIo->read($url, new Feed(), $modifiedSince)->getFeed();

        foreach ($feed as $item) {
//            echo "item title : {$item->getTitle()} \n ";
            // getMedias() returns enclosures if any
            $medias = $item->getMedias();
//            dd($item);
        }
    }
}
