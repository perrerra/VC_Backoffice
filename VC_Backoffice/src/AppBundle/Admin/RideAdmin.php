<?php

/**
 * Created by PhpStorm.
 * User: pierre
 * Date: 18/05/17
 * Time: 16:34
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RideAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user', 'entity',  array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'username',
            ))
            ->add('bike', 'entity',  array(
                'class' => 'AppBundle\Entity\Bike',
                'choice_label' => 'name',
            ))
/*            ->add('bike', null, array(
                'class' => 'AppBundle\Entity\Bike',
                'query_builder' => function($repository) {
                    return $repository->createQueryBuilder('u')
                        ->leftJoin('u.user', 'w')
                        ->where('w');
                }))*/
            ->add('startDate', 'datetime')
            ->add('endDate', 'datetime')
            ->add('description', 'textarea')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('startDate')
            ->add('endDate')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('user')
            ->add('startDate')
            ->add('endDate')
        ;
    }

/*    public function getTemplate($name)
    {

        switch ($name) {
            case 'edit':
                return 'AppBundle:RideAdmin:base_edit.html.twig';
                break;

            default:
                return parent::getTemplate($name);
                break;
        }
    }*/


}