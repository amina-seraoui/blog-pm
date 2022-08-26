<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabaseService
{
    public function __construct(private KernelInterface $kernel)
    {}

    public function createDatabase(): bool
    {
        $app = new Application($this->kernel);
        $app->setAutoExit(false); // La cmd ne se ferme pas toute seule

        $input = new ArrayInput(['command' => 'd:s:c']);
        $this->run($app, $input);

        $input = new ArrayInput(['command' => 'd:s:u', '--force' => true]);
        $this->run($app, $input);

        $input = new ArrayInput(['command' => 'd:f:l', '--append' => true]);
        $this->run($app, $input);

        return Command::SUCCESS;
    }

    private function run(Application $app, ArrayInput $input): bool
    {
        try {
            $result = $app->run($input);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }
}
