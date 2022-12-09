<?php

declare(strict_types=1);

namespace Tests\Support;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * @Given I am logged in
     */
     public function iAmLoggedIn()
     {
        $this->amOnPage('/user');
        $this->fillField('username', 'testuser');
        $this->fillField('password', 'testpassword1');
        $this->click('Login');
     }

     /**
     * @Given I am on :arg1
     */
     public function iAmOn($url)
     {
         $this->amOnPage($url);
     }

    /**
     * @When I click :arg1
     */
     public function iClick($arg1)
     {
         $this->click($arg1);
     }

    /**
     * @Then I see :arg1"
     */
     public function iSee($arg1)
     {
         $this->see($arg1);
     }
}
