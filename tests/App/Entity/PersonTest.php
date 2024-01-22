<?php

namespace Tests\App\Entity;

use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;
use Exception;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testGetName(): void
    {
        $person = new Person('Theo Pellizzari', 'USD');

        $this->assertEquals('Theo Pellizzari', $person->getName());
    }

    public function testGetWallet(): void
    {
        $person = new Person('Vincent', 'EUR');
        $wallet = new Wallet('EUR');
        $person->setWallet($wallet);

        $this->assertSame($wallet, $person->getWallet());
    }

    /**
     * @throws Exception
     */
    public function testTransferFund(): void
    {
        $person1 = new Person('Sender', 'USD');
        $wallet1 = new Wallet('USD');
        $wallet1->addFund(100.0);
        $person1->setWallet($wallet1);

        $person2 = new Person('Receiver', 'USD');
        $wallet2 = new Wallet('USD');
        $person2->setWallet($wallet2);

        $person1->transfertFund(50.0, $person2);

        $this->assertEquals(50.0, $wallet1->getBalance());
        $this->assertEquals(50.0, $wallet2->getBalance());
    }

    /**
     * @throws Exception
     */
    public function testBuyProduct(): void
    {
        $person = new Person('Customer', 'USD');
        $wallet = new Wallet('USD');
        $wallet->addFund(100.0);
        $person->setWallet($wallet);

        $product = new Product('Phone', ['USD' => 49.99], 'tech');

        $person->buyProduct($product);

        $expectedBalance = 50.01;

        $this->assertEquals($expectedBalance, $wallet->getBalance());
    }
}
