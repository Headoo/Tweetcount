<?php

namespace TweetCount\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;   // Symfony3
use Symfony\Component\Form\Extension\Core\Type\TextType;



class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $debug = "DEBUG: indexAction()";

        $response = null;
        // $request  = $this->getRequest(); Symfony2
        $form     = $this->createFormBuilder()
            ->add('url', TextType::class , array(
                'attr' => array(
                    'placeholder' => 'ef0bdd815d2a39741c4c30842b7f9488',
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
                dump($url);
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);

                $debug .= " ; URL:$url";

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
