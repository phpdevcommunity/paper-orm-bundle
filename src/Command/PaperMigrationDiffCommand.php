<?php

namespace PhpDevCommunity\PaperORMBundle\Command;

use PhpDevCommunity\PaperORM\Collector\EntityDirCollector;
use PhpDevCommunity\PaperORM\Command\Migration\MigrationDiffCommand;
use PhpDevCommunity\PaperORM\Migration\PaperMigration;
use PhpDevCommunity\PaperORMBundle\Tools\PhpDevCommunityConsoleWrapper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'paper:migration:diff', description: 'Generate a migration diff for the SQL database')]
class PaperMigrationDiffCommand extends Command
{
    private PaperMigration $migration;
    private EntityDirCollector $entityDirCollector;


    public function __construct(PaperMigration $migration, EntityDirCollector $entityDirCollector)
    {
        parent::__construct();
        $this->migration = $migration;
        $this->entityDirCollector = $entityDirCollector;
    }

    protected function configure(): void
    {
        $this
            ->setName('paper:migration:diff')
            ->setDescription('Generate a migration diff for the SQL database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return PhpDevCommunityConsoleWrapper::executeForSymfony(
            new MigrationDiffCommand($this->migration, $this->entityDirCollector), [], [], function ($message) use ($output) {
            $output->write($message);
        });
    }


}
