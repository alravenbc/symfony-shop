<?php

namespace AppBundle\Admin;

use AppBundle\Entity\Product;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class ProductAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper ->add('name', 'text')
                    ->add('price', 'integer')
                    ->add('description', 'textarea')
                    ->add('carts');
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper ->addIdentifier('name')
                    ->addIdentifier('price')
                    ->addIdentifier('description')
                    ->addIdentifier('product.carts');

    }

    public function toString($object)
    {
        return $object instanceof Product
            ? $object->getName()
            : 'Product'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('carts', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Cart',
                'choice_label' => 'name',
            ))
        ;
    }

}