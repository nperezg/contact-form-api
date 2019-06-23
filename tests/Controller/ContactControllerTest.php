<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    const ROUTE = '/api/contacts/';

    public function testCreate()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            self::ROUTE,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"email": "test@test.com", "message": "test message"}'
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertEquals(
            201,
            $client->getResponse()->getStatusCode()
        );

        $this->assertContains(
            'Contact created successfully.',
            $client->getResponse()->getContent()
        );
    }

    /**
     * @dataProvider provideValues
     * @param string $email
     * @param string $message
     */
    public function testValuesFailCreate(string $email, string $message)
    {
        $client = static::createClient();

        $client->request(
            'POST',
            self::ROUTE,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"email": "' . $email . '", "message": "' . $message . '"}'
        );

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $this->assertEquals(
            500,
            $client->getResponse()->getStatusCode()
        );

        $this->assertContains(
            'Error',
            $client->getResponse()->getContent()
        );
    }

    public function testMethodFailCreate()
    {
        $client = static::createClient();

        $client->request(
            'GET',
            self::ROUTE,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"email": "test@test.com", "message": "test message"}'
        );

        $this->assertEquals(
            405,
            $client->getResponse()->getStatusCode()
        );
    }

    public function provideValues()
    {
        return [
            ['wrongEmail', 'message'],
            ['test@test.com', ''],
            ['', ''],
        ];
    }
}