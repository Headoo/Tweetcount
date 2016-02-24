<?php

namespace TweetCount\ApiBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class TweetCountUrlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', UrlType::class, array(
            'required' => true
        ));

        $builder->add('apikey', TextType::class, array(
            'required' => true
        ));
    }

    public function getName()
    {
        return '';
    }
}
