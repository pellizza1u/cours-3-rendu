<?php

namespace Tests\App\Entity;

use App\Entity\Wallet;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour la classe Wallet.
 */
class WalletTest extends TestCase
{
    /**
     * Teste la méthode getBalance().
     *
     * Crée un portefeuille avec une devise spécifique et vérifie si la méthode getBalance
     * retourne le solde attendu.
     */
    public function testGetBalance(): void
    {
        $wallet = new Wallet('EUR');

        $this->assertEquals(0.0, $wallet->getBalance());
    }

    /**
     * Teste la méthode getCurrency().
     *
     * Crée un portefeuille avec une devise spécifique et vérifie si la méthode getCurrency
     * retourne la devise attendue.
     */
    public function testGetCurrency(): void
    {
        $wallet = new Wallet('USD');

        $this->assertEquals('USD', $wallet->getCurrency());
    }

    /**
     * Teste la méthode setBalance() avec un solde valide.
     *
     * Crée un portefeuille, change son solde et vérifie si le solde est modifié correctement.
     * @throws Exception
     */
    public function testSetBalanceAvecSoldeValide(): void
    {
        $wallet = new Wallet('EUR');
        $wallet->setBalance(150.0);

        $this->assertEquals(150.0, $wallet->getBalance());
    }

    /**
     * Teste la méthode setBalance() avec un solde invalide.
     *
     * Crée un portefeuille, tente de changer son solde avec un solde invalide
     * et vérifie si une exception est levée avec le message approprié.
     */
    public function testSetBalanceAvecSoldeInvalide(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Solde invalide');

        $wallet = new Wallet('USD');
        $wallet->setBalance(-50.0);
    }

    /**
     * Teste la méthode setCurrency() avec une devise valide.
     *
     * Crée un portefeuille, change sa devise et vérifie si la devise est modifiée correctement.
     * @throws Exception
     */
    public function testSetCurrencyAvecDeviseValide(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setCurrency('EUR');

        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    /**
     * Teste la méthode setCurrency() avec une devise invalide.
     *
     * Crée un portefeuille, tente de changer sa devise avec une devise invalide
     * et vérifie si une exception est levée avec le message approprié.
     */
    public function testSetCurrencyAvecDeviseInvalide(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Devise invalide');

        $wallet = new Wallet('USD');
        $wallet->setCurrency('invalidCurrency');
    }

    /**
     * Teste la méthode removeFund() avec un montant valide.
     *
     * Crée un portefeuille, ajoute des fonds, retire un montant et vérifie si
     * le solde est correct après le retrait.
     * @throws Exception
     */
    public function testRemoveFundAvecMontantValide(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100.0);
        $wallet->removeFund(50.0);

        $this->assertEquals(50.0, $wallet->getBalance());
    }

    /**
     * Teste la méthode removeFund() avec un montant invalide.
     *
     * Crée un portefeuille, tente de retirer un montant invalide
     * et vérifie si une exception est levée avec le message approprié.
     */
    public function testRemoveFundAvecMontantInvalide(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Montant invalide');

        $wallet = new Wallet('USD');
        $wallet->removeFund(-30.0);
    }

    /**
     * Teste la méthode removeFund() avec des fonds insuffisants.
     *
     * Crée un portefeuille avec un solde, tente de retirer un montant supérieur
     * au solde et vérifie si une exception est levée avec le message approprié.
     */
    public function testRemoveFundAvecFondsInsuffisants(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Fonds insuffisants');

        $wallet = new Wallet('USD');
        $wallet->setBalance(20.0);
        $wallet->removeFund(30.0);
    }

    /**
     * Teste la méthode addFund() avec un montant valide.
     *
     * Crée un portefeuille, ajoute des fonds et vérifie si le solde est correct après l'ajout.
     * @throws Exception
     */
    public function testAddFundAvecMontantValide(): void
    {
        $wallet = new Wallet('USD');
        $wallet->addFund(50.0);

        $this->assertEquals(50.0, $wallet->getBalance());
    }

    /**
     * Teste la méthode addFund() avec un montant invalide.
     *
     * Crée un portefeuille, tente d'ajouter un montant invalide
     * et vérifie si une exception est levée avec le message approprié.
     */
    public function testAddFundAvecMontantInvalide(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Montant invalide');

        $wallet = new Wallet('USD');
        $wallet->addFund(-30.0);
    }
}
