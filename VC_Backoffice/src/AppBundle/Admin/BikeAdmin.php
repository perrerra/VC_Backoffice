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

class BikeAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user', 'entity',  array(
                'class' => 'AppBundle\Entity\User',
                'choice_label' => 'username',
            ))
            ->add('name', 'text')
            ->add('wheelsize', 'integer')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user')
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('user')
            ->addIdentifier('name')
        ;
    }
}