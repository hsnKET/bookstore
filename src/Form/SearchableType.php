<?php

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchableType extends AbstractType
{




    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('class');
        $resolver->setDefaults([
            'compound' => false,
            'multiple' => true,
            'choice_value' => 'sexe',

        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {


        //dd($form->getData());
        $view->vars['expanded'] = false;
        $view->vars['placeholder'] = null;
        $view->vars['placeholder_in_choices'] = false;
        $view->vars['multiple'] = true;
        $view->vars['preferred_choices'] = [];
        $view->vars['choices'] = [new ChoiceView('h', 'j', 'h')];
        $view->vars['choice_value'] = 'sexe';
        $view->vars['choice_label'] = 'sexe';
        $view->vars['choice_translation_domain'] = false;
        $view->vars['full_name'] .= '[]';
    }

    /*public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(
            function (Collection $value): array {
                return $value->map(function ($v) {
                    return (string)$v->getId();
                })->toArray();
            },
            function (array $ids): Collection {
                if (empty($ids))
                    return new ArrayCollection([]);
                return new ArrayCollection([]);
            }
        ));
    }*/
    //get tableaux de choiceView
    public function choices(array $arr)
    {

        /** data | valuer | label
         *ChoiceView([], 'valeur', 'label')
         *valeur must be string
         */
        $objts = array();
        foreach ($arr as $obj) {
            $objts[] = new ChoiceView(
                $obj,
                (string) $obj->getId(),
                $obj->getNomPrenom()
            );
        }
        return $objts;
    }
    //prefix que nous avons utilisé
    public function getBlockPrefix()
    {
        return 'choice';
    }
}
