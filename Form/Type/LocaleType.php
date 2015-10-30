<?php

namespace FDevs\Locale\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Intl\Intl;

class LocaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (is_array($options['lang_code'])) {
            $intlBundle = Intl::getLanguageBundle();
            $localeChoices = [];
            foreach ($options['lang_code'] as $code) {
                $localeChoices[$code] = $intlBundle->getLanguageName($code);
            }
            $builder->add('locale', 'choice', ['choices' => $localeChoices]);
        } else {
            $builder->add('locale', 'hidden', ['data' => $options['lang_code'], 'empty_data' => $options['lang_code']]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['lang_code'])
            ->setDefaults([
                'compound' => true,
                'options' => [
                    'label' => false,
                    'data_class' => null,
                    'compound' => false,
                    'required' => true,
                    'read_only' => false,
                    'max_length' => null,
                    'mapped' => true,
                    'by_reference' => true,
                    'trim' => true,
                ],
            ])
            ->addAllowedTypes('lang_code', ['string', 'array'])
            ->addAllowedTypes('options', ['array'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'fdevs_locale';
    }
}
