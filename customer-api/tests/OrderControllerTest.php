<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{

    /** @test */
    public function getOrders()
    {
        $client = static::createClient();
        $client->request('GET','/api/orders',[],[],
            ['headers' =>['Authorization' =>
                'Bearer [TOKEN]']]
        );

        $this->assertJson($client->getResponse()->getContent());
    }

    /** @test */
    public function getOrder()
    {
        $client = static::createClient();
        $client->request('GET','/api/order/1',[],[],
            ['Authorization' =>
                'Bearer [TOKEN]']
        );

        $this->assertJson($client->getResponse()->getContent());
    }

    /** @test */
    public function postOrder()
    {
        $client = static::createClient();
        $client->request('POST','/api/order',[],[],
            [ 'Authorization' =>
        ['Bearer' =>  '[TOKEN]']]
        );

        $this->assertJson($client->getResponse()->getContent());
    }

    /** @test */
    public function putOrder()
    {
        $client = static::createClient();
        $client->request('PUT','/api/order/1',[],[],
            [ 'Authorization' =>
        ['Bearer' =>  '[TOKEN]']]
        );

        $this->assertJson($client->getResponse()->getContent());
    }

}