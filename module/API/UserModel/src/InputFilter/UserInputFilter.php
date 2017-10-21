<?php
/**
 * Created by PhpStorm.
 * @author: aa43681 - Mike Peters <mike@petmi627.lu>
 * @datetime: 21/10/2017 21:40
 */

namespace API\UserModel\InputFilter;


use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;

class UserInputFilter extends InputFilter implements UserInputFilterInterface
{
    private $language_options;

    /**
     * @param mixed $language_options
     */
    public function setLanguageOptions($language_options)
    {
        $this->language_options = $language_options;
    }

    public function init()
    {
        $this->add([
            'name'        => 'language',
            'required'    => true,
            'filter'      => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators'  => [
                [
                    'name'                          => NotEmpty::class,
                    'break_chain_on_failure'        => true,
                    'options'                       => [
                        'message'   => 'No language entered'
                    ]
                ],
                [
                    'name'                          => InArray::class,
                    'options'                       => [
                        'haystack'  => $this->language_options,
                        'message'   => 'Language invalid',
                    ]
                ]
            ]
        ]);
    }
}