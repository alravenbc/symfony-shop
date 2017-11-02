<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("product")
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();
        $carts = $em->getRepository('AppBundle:Cart')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            'carts' => $carts,
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {

        return $this->render('product/show.html.twig', array(
            'product' => $product,
        ));
    }

    /**
     * Adds to Cart a product entity.
     *
     * @Route("/{id}/add", name="product_addtocart")
     * @Method({"GET", "POST"})
     */
    public function addtocartAction(Request $request, Product $product)
    {
        $addtocartForm = $this->createForm('AppBundle\Form\Addtocart', $product);
        $addtocartForm->handleRequest($request);

        if ($addtocartForm->isSubmitted() && $addtocartForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_addtocart', array('id' => $product->getId()));
        }

        return $this->render('product/addtocart.html.twig', array(
            'product' => $product,
            'addtocart_form' => $addtocartForm->createView(),
        ));
    }

    //move to cart controller

    /**
     * Finds and displays a cart entity. If ordered, other actions are blocked.
     *
     * @Route("/cart/{id}", name="cart_show")
     * @Method({"GET", "POST"})
     */
    public function showcartAction(Cart $cart, Request $request)
    {

        if ($cart->getStatus()=='1')
        {
            return $this->render('product/order.html.twig', array(
                'cart' => $cart,));
        }
        if ($request->isMethod('post'))
        {
            $ids = $request->get('delete', array());
            $em = $this->getDoctrine()->getManager();
            $products = $em->getRepository('AppBundle:Product')->findById($ids);

            foreach ($products as $product)
            {
                $product->removeCart($cart);
            }

            $em->flush();
        }

        return $this->render('product/showcart.html.twig', array(
            'cart' => $cart,
        ));
    }

    /**
     * Shows products in Cart and enables ordering.
     *
     * @Route("/order/cart/{id}", name="order_products")
     * @Method({"GET", "POST"})
     */
    public function orderAction(Cart $cart, Request $request)
    {

        if ($request->isMethod('post'))
        {
            $em = $this->getDoctrine()->getManager();
            $cart->setStatus(1);
            $em->flush();
        }

        return $this->render('product/order.html.twig', array(
            'cart' => $cart,
        ));
    }
}
