<?php

use Codeception\Attribute\Given;
use Codeception\Attribute\Then;
use Codeception\Attribute\When;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method self execute($callable)
 * @method self expectTo($prediction)
 * @method self expect($prediction)
 * @method self amGoingTo($argumentation)
 * @method self am($role)
 * @method self lookForwardTo($achieveValue)
 * @method self comment($description)
 * @method void haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
*/
class ScenarioGuy extends \Codeception\Actor
{
    use _generated\ScenarioGuyActions;

    public function seeCodeCoverageFilesArePresent()
    {
        $this->seeFileFound('c3.php');
        $this->seeFileFound('composer.json');
        $this->seeInThisFile('codeception/c3');
    }

    #[Given('I have terminal opened')]
    public function terminal()
    {
        $this->comment('I am terminal user!');
    }

    #[When('I am in current directory')]
    public function openCurrentDir()
    {
        $this->amInPath('.');
    }

    #[Given('I am inside :dir')]
    public function openDir($path)
    {
        $this->amInPath($path);
    }

    #[Then('there is a file :name')]
    #[Then('I see file :name')]
    public function matchFile($name)
    {
        $this->seeFileFound($name);
    }

    #[Then('there are keywords in :smth')]
    public function thereAreValues($file, \Behat\Gherkin\Node\TableNode $node)
    {
        $this->seeFileFound($file);
        foreach ($node->getRows() as $row) {
            $this->seeThisFileMatches('~' . implode('.*?', $row) . '~');
        }
    }

    #[Then('I see output :arg1')]
    public function iSeeOutput($arg1)
    {
    }

    #[Then('I print :arg1')]
    public function iPrint($arg1)
    {
        echo "Argument: $arg1\n";
    }

    #[Given('/multiple step definitions/')]
    public function definition1()
    {
        echo __METHOD__ . ' was executed';
    }

    #[Given('/a step which matches/')]
    public function definition2()
    {
        echo __METHOD__ . ' was executed';
    }
}
