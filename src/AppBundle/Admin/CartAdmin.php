<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CartAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper ->add('name', 'text')
                    ->add('email', 'text')
                    ->add('status', 'integer')
                    ->add('products');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper ->add('name')
                        ->add('email')
                        ->add('status')
                        ->add('products');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper ->addIdentifier('name')
                    ->addIdentifier('email')
                    ->addIdentifier('status')
                    ->addIdentifier('products');
    }

}