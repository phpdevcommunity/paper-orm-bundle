<?php

namespace PhpDevCommunity\PaperORMBundle\Tools;

use PhpDevCommunity\Console\Command\CommandInterface;
use PhpDevCommunity\Console\CommandParser;
use PhpDevCommunity\Console\CommandRunner;
use PhpDevCommunity\Console\Output;
use Symfony\Component\Console\Command\Command;

final class PhpDevCommunityConsoleWrapper
{

    public static function executeForSymfony(CommandInterface $command, array $arguments = [], array $options = [], callable $stdout = null): int
    {
        $app = new CommandRunner([$command]);
        $exitCode = $app->run(new CommandParser(array_merge([''], [$command->getName()], $arguments, $options)), new Output($stdout));

        if ($exitCode === CommandRunner::CLI_ERROR) {
            return Command::FAILURE;
        }
        if ($exitCode !== CommandRunner::CLI_SUCCESS) {
            return Command::INVALID;
        }

        return Command::SUCCESS;
    }
}
