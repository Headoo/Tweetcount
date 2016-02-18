<?php

namespace TweetCount\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $response = null;
        $request  = $this->getRequest();
        $form     = $this->createFormBuilder()
            ->add('url', 'url', array(
                'attr' => array(
                    'placeholder' => 'http://www.example.com',
                    'class' => 'input-lg'
                )
            ))
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $params = array(
                    'apikey' => 'xoxo', // set default api key
                    'url'    => $form->get('url')->getData()
                );

                // Call internal api
                $url = $this->generateUrl('tweet_count_api_url', array(), true);
                $url.= '?' . http_build_query($params);

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);

                if ($response !== null) {
                    $response = json_decode($response);
                }
            }
        }

        return $this->render('TweetCountWebsiteBundle:Default:index.html.twig', array(
            'form'     => $form->createView(),
            'response' => $response
        ));
    }
}
