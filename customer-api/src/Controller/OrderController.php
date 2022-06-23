<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\QueryBuilder;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class OrderController
 * @package App\Controller
 *
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/order", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function postOrder(Request $request)
    {
        $ent = $this->getDoctrine()->getManager();

        $rawData = json_decode($request->getContent(),true);

        /** @var Customer|null $customer */
        $customer = $ent->getRepository(Customer::class)->findOneBy(['id' => $rawData['customer']]);
        if (is_null($customer)){
            return new JsonResponse(['message' => sprintf('Customer %s not found', $rawData['customer'])],Response::HTTP_NOT_FOUND);
        }

        /** @var Product|null $product */
        $product = $ent->getRepository(Product::class)->findOneBy(['id' => $rawData['product']]);
        if (is_null($product)){
            return new JsonResponse(['message' => sprintf('Product %s not found', $rawData['product'])],Response::HTTP_NOT_FOUND);
        }

        $order = new Order();
        $shippingDate = date_create_from_format('Y-m-d H:i:s', $rawData['shippingDate']);
        $shippingDate->getTimestamp();

        $order->setCustomer($customer)->setProduct($product)->setAddress($rawData['address'])->
        setOrderCode($rawData['orderCode'])->setQuantity($rawData['quantity'])
            ->setShippingDate($shippingDate);

        // Sonuç olarak sipariş kaydı yapmak istediğinizi Doctrine'e bildirme
        $ent->persist($order);
        $ent->flush(); // Sorgulamayı gerçekleştirme

        return new JsonResponse(['message'=> sprintf('Order %s successfully created', $order->getId()), 'set' => $order->getId()],Response::HTTP_OK);
    }

    /**
     * @Route("/order/{id}", methods={"PUT"})
     * @param Request $request
     * @param $orderId
     * @return Response
     */
    public function updateOrder(Request $request,$orderId)
    {
        $ent = $this->getDoctrine()->getManager();

        $rawData = json_decode($request->getContent(),true);

        /** @var OrderRepository $OrderRepo */
        $orderRepo = $ent->getRepository(Order::class);

        $filters = [
            'orderStatus' => [1],
            'id' => $orderId
        ];

        /** @var Order|null $order */
        $order = $orderRepo->lastShippingOrder($filters);
        
        if (is_null($order)){
            return new JsonResponse(['message' => sprintf('Order %s not found', $rawData['customer'])],Response::HTTP_NOT_FOUND);
        }

        /** @var Customer|null $customer */
        $customer = $ent->getRepository(Customer::class)->findOneBy(['id' => $rawData['customer']]);
        if (is_null($customer)){
            return new JsonResponse(['message' => sprintf('Customer %s not found', $rawData['customer'])],Response::HTTP_NOT_FOUND);
        }

        /** @var Product|null $product */
        $product = $ent->getRepository(Product::class)->findOneBy(['id' => $rawData['product']]);
        if (is_null($product)){
            return new JsonResponse(['message' => sprintf('Product %s not found', $rawData['product'])],Response::HTTP_NOT_FOUND);
        }

        $shippingDate = date_create_from_format('Y-m-d H:i:s', $rawData['shippingDate']);
        $shippingDate->getTimestamp();

        $order->setCustomer($customer)->setProduct($product)->setAddress($rawData['address'])->setOrderStatus($rawData['orderStatus'])
            ->setOrderCode($rawData['orderCode'])->setQuantity($rawData['quantity'])->setShippingDate($shippingDate);

        $ent->persist($order);
        $ent->flush();

        return new JsonResponse(['message'=> sprintf('Order %s successfully updated', $order->getId()), 'set' => $order->getId()],Response::HTTP_OK);
    }


    /**
     * @Route("/order/{id}", methods={"GET"})
     * @param $orderId
     * @return JsonResponse
     */
    public function getOrder($orderId): JsonResponse
    {
        $ent = $this->getDoctrine()->getManager();

        /** @var Order|null $order */
        $order = $ent->getRepository(Order::class)->findOneBy(['id' => $orderId]);
        if (is_null($order)){
            return new JsonResponse(['message' => sprintf('Order %s not found',$orderId)],Response::HTTP_NOT_FOUND);
        }
        $response = $this->buildSerializer(['set' => $order]);
        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/orders", methods={"GET"})
     * @return JsonResponse
     */
    public function getOrders(): JsonResponse
    {
        $ent = $this->getDoctrine()->getManager();

        /** @var OrderRepository $orderRepo */
        $orderRepo = $ent->getRepository(Order::class);

        $orders = $orderRepo->findAll();

        if (empty($orders)){
            return new JsonResponse(['message' => sprintf('Orders not found')],Response::HTTP_NOT_FOUND);
        }

        $response = $this->buildSerializer(['set' => $orders]);
        return new JsonResponse($response, Response::HTTP_OK);
    }


    private function buildSerializer($data, $contextGroups = [])
    {
        $serializer = SerializerBuilder::create();
        $serializer->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());
        $serializer = $serializer->build();

        return $serializer->toArray($data);
    }

}
