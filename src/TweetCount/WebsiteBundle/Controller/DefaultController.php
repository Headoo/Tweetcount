<?php

namespace TweetCount\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;   // Symfony3
use Symfony\Component\Form\Extension\Core\Type\UrlType;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $debug = "DEBUG: indexAction()";

        $response = null;
        // $request  = $this->getRequest(); Symfony2
        $form     = $this->createFormBuilder()
            ->add('url', UrlType::class , array(
                'attr' => array(
                    'placeholder' => 'http://www.example.com',
                    'class' => 'input-lg'
                )
            ))
            ->getForm();

        $debug .= " ; " . print_r($request->getMethod(), true);

        if ($request->getMethod() == 'POST') {

            $debug .= " ; POST OK";
            dump("OK");

            $form->handleRequest($request);

            if ($form->isValid()) {
                $debug .= " ; FormIsValid";

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

                $debug .= " ; URL:$url";
                dump($response);

                if ($response !== null) {
                    $response = json_decode($response);
                }
            }
        }

        return $this->render('TweetCountWebsiteBundle:Default:index.html.twig', array(
            'form'     => $form->createView(),
            'response' => $response,
            'debug'    => $debug
        ));
    }
}
