<?php

namespace TweetCount\ApiBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class UrlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('url', 'url', array(
            'required' => true
        ));

        $builder->add('apikey', 'text', array(
            'required' => true
        ));
    }

    public function getName()
    {
        return '';
    }
}
