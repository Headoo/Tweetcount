<?php

namespace TweetCount\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use TweetCount\ApiBundle\Form\UrlType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createForm(new UrlType(), null, array(
            'method'          => 'GET',
            'csrf_protection' => false
        ));

        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            try {
                $manager  = $this->get('headoo.twitter.tweet_manager');
                $response = $manager->searchTweetWithURL($form->get('url')->getData(), 100);

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
            } catch (\Exception $e) {
                $data = array('error' => $e->getMessage());
                error_log($e->getMessage());
                error_log($e->getTraceAsString());
            }
        } else {
            $data = array('error' => 'Bad parameters');
        }

        return new JsonResponse($data);
    }
}
