<?php

namespace PhpDevCommunity\PaperORMBundle\Command;

use http\Encoding\Stream;
use PhpDevCommunity\PaperORM\Command\DatabaseCreateCommand;
use PhpDevCommunity\PaperORM\Command\DatabaseSyncCommand;
use PhpDevCommunity\PaperORM\EntityManagerInterface;
use PhpDevCommunity\PaperORM\Migration\PaperMigration;
use PhpDevCommunity\PaperORMBundle\Tools\PhpDevCommunityConsoleWrapper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'paper:database:sync', description: 'Update the SQL database structure so it matches the current ORM entities.')]
class PaperDatabaseSyncCommand extends Command
{
    private PaperMigration $migration;
    private string $entitiesDir;

    /**
     * @var string
     */
    private $env;

    public function __construct(PaperMigration $migration, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->migration = $migration;
        $this->entitiesDir = $params->get('paper_orm.entity_dir');
        $this->env = $params->get('kernel.environment');
    }

    protected function configure(): void
    {
        $this
            ->setName('paper:database:sync')
            ->setDescription('Update the SQL database structure so it matches the current ORM entities.')
            ->addOption('no-execute', null, InputOption::VALUE_NONE, 'Show the generated SQL statements without executing them.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $options = [];
        $noExecute = $input->getOption('no-execute');
        if ($noExecute) {
            $options = ['--no-execute'];
        }
        return PhpDevCommunityConsoleWrapper::executeForSymfony(new DatabaseSyncCommand($this->migration, $this->entitiesDir, strtolower($this->env)), [], $options, function ($message) use ($output) {
            $output->write($message);
        });
    }


}
