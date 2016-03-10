<?php

namespace TweetCount\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    private $container;

   public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }



    public function testTweetManager() {
        $manager  = $this->container->get('headoo.twitter.tweet_manager');
        $response = $manager->getStatsForTweetWithURL(urldecode("http://google.com"), 100);
    }
}
