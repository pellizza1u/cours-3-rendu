<?php

namespace Tests\App\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour la classe Product.
 */
class ProductTest extends TestCase
{
    /**
     * Teste la méthode getName().
     *
     * Crée un produit avec un nom spécifique et vérifie si la méthode getName
     * retourne le nom attendu.
     */
    public function testGetName(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');

        $this->assertEquals('Ordinateur', $product->getName());
    }

    /**
     * Teste la méthode getPrices().
     *
     * Crée un produit avec des prix spécifiques et vérifie si la méthode getPrices
     * retourne les prix attendus.
     */
    public function testGetPrices(): void
    {
        $prices = ['USD' => 1299.99, 'EUR' => 1099.99];
        $product = new Product('Ordinateur', $prices, 'tech');

        $this->assertEquals($prices, $product->getPrices());
    }

    /**
     * Teste la méthode getType().
     *
     * Crée un produit avec un type spécifique et vérifie si la méthode getType
     * retourne le type attendu.
     */
    public function testGetType(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');

        $this->assertEquals('tech', $product->getType());
    }

    /**
     * Teste la méthode setType() avec une valeur valide.
     *
     * Crée un produit, change son type et vérifie si le type est modifié correctement.
     * @throws \Exception
     */
    public function testSetTypeValide(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $product->setType('electronics');

        $this->assertEquals('electronics', $product->getType());
    }

    /**
     * Teste la méthode setType() avec une valeur invalide.
     *
     * Crée un produit, tente de changer son type avec une valeur invalide et vérifie
     * si une exception est levée avec le message approprié.
     */
    public function testSetTypeInvalide(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Type invalide');

        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $product->setType('typeInvalide');
    }

    /**
     * Teste la méthode setPrices().
     *
     * Crée un produit, change ses prix et vérifie si les prix sont modifiés correctement.
     */
    public function testSetPrices(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $newPrices = ['USD' => 1399.99, 'EUR' => 1199.99];
        $product->setPrices($newPrices);

        $this->assertEquals($newPrices, $product->getPrices());
    }

    /**
     * Teste la méthode setPrices() avec une devise invalide.
     *
     * Crée un produit, tente de changer ses prix avec une devise invalide et vérifie
     * si la devise invalide est ignorée.
     */
    public function testSetPricesAvecDeviseInvalide(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $newPrices = ['USD' => 1399.99, 'GBP' => 1199.99];
        $product->setPrices($newPrices);

        $expectedPrices = ['USD' => 1399.99, 'EUR' => 1099.99];
        $this->assertEquals($expectedPrices, $product->getPrices());
    }

    /**
     * Teste la méthode setPrices() avec un prix négatif.
     *
     * Crée un produit, tente de changer ses prix avec un prix négatif et vérifie
     * si une exception est levée avec le message approprié.
     */
    public function testSetPricesAvecPrixNegatif(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $newPrices = ['USD' => -1399.99, 'EUR' => 1199.99];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le prix ne peut pas être négatif');

        $product->setPrices($newPrices);
    }

    /**
     * Teste la méthode getTVA() pour un produit alimentaire.
     *
     * Crée un produit alimentaire et vérifie si la TVA est correcte.
     */
    public function testGetTVAProduitAlimentaire(): void
    {
        $produitAlimentaire = new Product('Barre de chocolat', ['USD' => 2.99], 'food');

        $this->assertEquals(0.1, $produitAlimentaire->getTVA());
    }

    /**
     * Teste la méthode getTVA() pour un produit non alimentaire.
     *
     * Crée un produit non alimentaire et vérifie si la TVA est correcte.
     */
    public function testGetTVAPourProduitNonAlimentaire(): void
    {
        $produitTechnologique = new Product('Casque audio', ['USD' => 199.99], 'tech');

        $this->assertEquals(0.2, $produitTechnologique->getTVA());
    }

    /**
     * Teste la méthode listCurrencies().
     *
     * Crée un produit et vérifie si la liste des devises est correcte.
     */
    public function testListeDeDevises(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');

        $this->assertEquals(['USD', 'EUR'], $product->listCurrencies());
    }

    /**
     * Teste la méthode getPrice().
     *
     * Crée un produit et vérifie si le prix pour une devise spécifique est correct.
     */
    public function testGetPrix(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');

        $this->assertEquals(1299.99, $product->getPrice('USD'));
    }

    /**
     * Teste la méthode getPrice() avec une devise invalide.
     *
     * Crée un produit, tente de récupérer le prix avec une devise invalide et vérifie
     * si une exception est levée avec le message approprié.
     */
    public function testGetPrixAvecDeviseInvalide(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Devise invalide');

        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');
        $product->getPrice('GBP');
    }

    /**
     * Teste la méthode getPrice() avec une devise non disponible pour le produit.
     *
     * Crée un produit, tente de récupérer le prix avec une devise non disponible et vérifie
     * si une exception est levée avec le message approprié.
     */
    public function testGetPrixAvecDeviseNonDisponiblePourLeProduit(): void
    {
        $product = new Product('Ordinateur', ['USD' => 1299.99, 'EUR' => 1099.99], 'tech');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Devise non disponible pour ce produit');

        $product->getPrice('GBP');
    }
}
