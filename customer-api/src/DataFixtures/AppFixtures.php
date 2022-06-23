<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i =0; $i < 4; $i++) {
            $customer = new Customer('customer'.($i+1));
            // password: customer123.
            $customer->setPassword('$2y$10$QFtFmfl/2pNweeNh8LyOhezjXwUrCivppfM81Qg6BDK5Rknml3Rxa');
            $manager->persist($customer);
        }

        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->setName('product'.$i);
            $product->setCode('product-code-'.$i);
            $manager->persist($product);
        }

        $manager->flush();

        /** @var Product[] $products */
        $products = $manager->getRepository(Product::class)->findAll();

        /** @var Customer[] $customers */
        $customers = $manager->getRepository(Customer::class)->findAll();

        for ($i = 0; $i < 3; $i++) {
            $order = new Order();

            $shippingDate = date_create_from_format('Y-m-d H:i:s', '2022-06-23 23:14:00');
            $shippingDate->getTimestamp();
            $order->setProduct($products[$i]);
            $order->setCustomer($customers[$i]);
            $order->setAddress($faker->address);
            $order->setOrderCode('code'.$i);
            $order->setQuantity($i+1);
            $order->setShippingDate($shippingDate);

            $manager->persist($order);
        }
        $manager->flush();
    }
}
