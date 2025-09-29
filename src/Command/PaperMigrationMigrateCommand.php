<?php

namespace PhpDevCommunity\PaperORMBundle\Command;

use PhpDevCommunity\PaperORM\Command\Migration\MigrationMigrateCommand;
use PhpDevCommunity\PaperORM\Migration\PaperMigration;
use PhpDevCommunity\PaperORMBundle\Tools\PhpDevCommunityConsoleWrapper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'paper:migration:migrate', description: 'Execute all migrations',)]
class PaperMigrationMigrateCommand extends Command
{
    private PaperMigration $migration;

    public function __construct(PaperMigration $migration)
    {
        parent::__construct();
        $this->migration = $migration;
    }

    protected function configure(): void
    {
        $this
            ->setName('paper:migration:migrate')
            ->setDescription('Execute all migrations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return PhpDevCommunityConsoleWrapper::executeForSymfony(new MigrationMigrateCommand($this->migration), [], [], function ($message) use ($output) {
            $output->write($message);
        });
    }
}
