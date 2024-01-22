<?php

namespace Tests\App\Entity;

use App\Entity\Person;
use App\Entity\Wallet;
use App\Entity\Product;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour la classe Person.
 */
class PersonTest extends TestCase
{
    /**
     * Teste la méthode getName().
     *
     * Crée une personne avec un nom spécifique et vérifie si la méthode getName
     * retourne le nom attendu.
     */
    public function testGetName(): void
    {
        $person = new Person('Theo Pellizzari', 'USD');

        $this->assertEquals('Theo Pellizzari', $person->getName());
    }

    /**
     * Teste la méthode getWallet().
     *
     * Crée une personne avec un portefeuille spécifique et vérifie si la méthode getWallet
     * retourne le portefeuille attendu.
     */
    public function testGetWallet(): void
    {
        $person = new Person('Vincent Brach', 'EUR');
        $wallet = new Wallet('EUR');
        $person->setWallet($wallet);

        $this->assertSame($wallet, $person->getWallet());
    }

    /**
     * Teste le transfert de fonds entre personnes.
     *
     * Crée une personne qui envoie de l'argent et une personne qui reçoit.
     * Transfère des fonds de la première personne à la deuxième et vérifie
     * si les soldes des portefeuilles sont corrects après le transfert.
     *
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
     * Teste l'achat d'un produit par une personne.
     *
     * Crée une personne cliente avec un portefeuille, un produit à acheter,
     * et vérifie si le solde du portefeuille est correct après l'achat.
     *
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

    /**
     * Teste le transfert de fonds avec différentes devises.
     *
     * Vérifie qu'une exception est levée si une personne essaie de transférer des fonds
     * à une autre personne avec une devise différente.
     *
     * @throws Exception
     */
    public function testTransferFundDifferentCurrency(): void
    {
        $person1 = new Person('Sender', 'USD');
        $wallet1 = new Wallet('USD');
        $wallet1->addFund(100.0);
        $person1->setWallet($wallet1);

        $person2 = new Person('Receiver', 'EUR'); // Personne avec une devise différente
        $wallet2 = new Wallet('EUR');
        $person2->setWallet($wallet2);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Impossible de donner de l'argent avec des devises différentes");

        $person1->transfertFund(50.0, $person2);
    }

    /**
     * Teste la division du portefeuille entre plusieurs personnes.
     *
     * Vérifie que la méthode divideWallet fonctionne correctement en vérifiant que les soldes
     * des portefeuilles des personnes sont corrects après la division.
     *
     * @throws Exception
     */
    public function testDivideWallet(): void
    {
        $person1 = new Person('Personne1', 'USD');
        $person2 = new Person('Personne2', 'USD');
        $person3 = new Person('Personne3', 'USD');

        $persons = [$person1, $person2, $person3];

        $person1->getWallet()->addFund(300.0);

        $person1->divideWallet($persons);

        foreach ($persons as $person) {
            $this->assertEquals(100.0, $person->getWallet()->getBalance());
        }
    }

    /**
     * Teste l'achat d'un produit avec une devise non prise en charge par le portefeuille.
     *
     * Vérifie qu'une exception est levée si une personne essaie d'acheter un produit
     * avec une devise non prise en charge par le portefeuille.
     *
     * @throws Exception
     */
    public function testBuyProductUnsupportedCurrency(): void
    {
        $person = new Person('Customer', 'USD');
        $wallet = new Wallet('USD');
        $wallet->addFund(100.0);
        $person->setWallet($wallet);

        $product = new Product('Phone', ['EUR' => 49.99], 'tech');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Impossible d'acheter un produit avec cette devise de portefeuille");

        $person->buyProduct($product);
    }

    /**
     * Teste l'achat d'un produit avec un solde insuffisant dans le portefeuille.
     *
     * Vérifie qu'une exception est levée si une personne essaie d'acheter un produit
     * avec un solde insuffisant dans le portefeuille.
     *
     * @throws Exception
     */
    public function testBuyProductInsufficientBalance(): void
    {
        $person = new Person('Customer', 'USD');
        $wallet = new Wallet('USD');
        $wallet->addFund(49.99); // Solde insuffisant pour acheter un produit de 50.0
        $person->setWallet($wallet);

        $product = new Product('Phone', ['USD' => 50.0], 'tech');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Fonds insuffisants');

        $person->buyProduct($product);
    }
}
