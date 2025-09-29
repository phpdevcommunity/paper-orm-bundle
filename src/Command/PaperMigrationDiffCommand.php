<?php

namespace PhpDevCommunity\PaperORMBundle\Command;

use PhpDevCommunity\Console\CommandRunner;
use PhpDevCommunity\PaperORM\Command\DatabaseCreateCommand;
use PhpDevCommunity\PaperORM\Command\Migration\MigrationDiffCommand;
use PhpDevCommunity\PaperORM\EntityManagerInterface;
use PhpDevCommunity\PaperORM\Migration\PaperMigration;
use PhpDevCommunity\PaperORMBundle\Tools\PhpDevCommunityConsoleWrapper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'paper:migration:diff', description: 'Generate a migration diff for the SQL database')]
class PaperMigrationDiffCommand extends Command
{
    private PaperMigration $migration;
    private string $entitiesDir;

    public function __construct(PaperMigration $migration, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->migration = $migration;
        $this->entitiesDir = $params->get('paper_orm.entity_dir');
    }

    protected function configure(): void
    {
        $this
            ->setName('paper:migration:diff')
            ->setDescription('Generate a migration diff for the SQL database')
            ->addOption('output', 'o', InputOption::VALUE_NONE, 'The output file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $options = [];
        $printOutput = $input->getOption('output');
        if ($printOutput) {
            $options = ['--output'];
        }
        return PhpDevCommunityConsoleWrapper::executeForSymfony(new MigrationDiffCommand($this->migration, $this->entitiesDir), [], $options, function ($message) use ($output) {
            $output->write($message);
        });
    }


}
