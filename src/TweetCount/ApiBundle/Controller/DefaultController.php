<?php

namespace TweetCount\ApiBundle\Controller;

use Doctrine\Tests\Models\Tweet\Tweet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use TweetCount\ApiBundle\Form\TCUrlType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    
        $manager  = $this->get('headoo.twitter.tweet_manager');
        dump(urldecode($request->get('url')));

        $response = $manager->getStatsForTweetWithURL(urldecode($request->get('url')), 100);


        return new JsonResponse($response);
    }
}
