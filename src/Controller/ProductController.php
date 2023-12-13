<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductController extends AbstractController
{
    public function list(EntityManager $em): string
    {
        $product = new Product();
        $product
            ->setName(name: "sIgTKZNDZrr")
            ->setPrice(76.24);

        $em->persist($product);
        $em->flush();

        return $this->twig->render("products/list.html.twig", [
            'product' => $product
        ]);
    }
}
