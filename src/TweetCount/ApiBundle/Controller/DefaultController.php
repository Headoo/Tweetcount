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
        $response = $manager->searchTweetWithURL(urldecode($request->get('url')), 100);

        if ($response !== null) {
            $shared   = count($response->statuses);
            $favorite = 0;

            foreach ($response->statuses as $item) {
                if ($item->favorited === true) {
                    $favorite++;
                }
            }
        } else {
            $shared = $favorite = 0;
        }

        $data = array('twitter' => array(
            'shared'    => $shared,
            'favorited' => $favorite
        ));

        return new JsonResponse($data);
    }
}
