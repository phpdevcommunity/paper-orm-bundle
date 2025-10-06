<?php

namespace Test\PhpDevCommunity\PaperORMBundle;

use PhpDevCommunity\PaperORMBundle\Command\PaperDatabaseCreateCommand;
use PhpDevCommunity\PaperORMBundle\Command\PaperDatabaseDropCommand;
use PhpDevCommunity\PaperORMBundle\Command\PaperDatabaseSyncCommand;
use PhpDevCommunity\PaperORMBundle\Command\PaperMigrationDiffCommand;
use PhpDevCommunity\PaperORMBundle\Command\PaperMigrationMigrateCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Test\PhpDevCommunity\PaperORMBundle\Fixtures\TestKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class CommandTest extends KernelTestCase
{

    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();
    }

    public function testCreateDatabaseCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = self::$kernel->getContainer()->get(PaperDatabaseCreateCommand::class);
        $application->add($command);

        $commandTester = new CommandTester($application->find('paper:database:create'));
        $exitCode = $commandTester->execute([
            '--if-not-exists' => true,
        ]);

        $this->assertSame(0, $exitCode, 'Command should return success code 0');
        $this->assertStringContainsString(
            '[INFO] The SQL database ":memory:" has been successfully created (if it did not already exist).',
            $commandTester->getDisplay()
        );
    }

    public function testDropDatabaseCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = self::$kernel->getContainer()->get(PaperDatabaseDropCommand::class);
        $application->add($command);

        $commandTester = new CommandTester($application->find('paper:database:drop'));
        $exitCode = $commandTester->execute([
        ]);

        $this->assertSame(1, $exitCode, 'Command should return success code 1');
        $this->assertStringContainsString(
            '[ERROR] You must use the --force option to drop the database.',
            $commandTester->getDisplay()
        );
        $exitCode = $commandTester->execute([
            '--force' => true
        ]);

        $this->assertSame(0, $exitCode, 'Command should return success code 0');
        $this->assertStringContainsString(
            '[OK] The SQL database has been successfully dropped.',
            $commandTester->getDisplay()
        );
    }

    public function testDatabaseSyncCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = self::$kernel->getContainer()->get(PaperDatabaseSyncCommand::class);
        $application->add($command);

        $commandTester = new CommandTester($application->find('paper:database:sync'));
        $exitCode = $commandTester->execute([
        ]);


        $this->assertSame(0, $exitCode, 'Command should return success code 0');
        $this->assertStringContainsString(
            'No differences detected — all entities are already in sync with the database schema.',
            $commandTester->getDisplay()
        );
    }

    public function testMigrationDiffCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = self::$kernel->getContainer()->get(PaperMigrationDiffCommand::class);
        $application->add($command);

        $commandTester = new CommandTester($application->find('paper:migration:diff'));
        $exitCode = $commandTester->execute([
        ]);

        $this->assertSame(0, $exitCode, 'Command should return success code 0');
        $this->assertStringContainsString(
            '[INFO] No migration file was generated — all entities are already in sync with the database schema.',
            $commandTester->getDisplay()
        );
    }

    public function testMigrationMigrateCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $command = self::$kernel->getContainer()->get(PaperMigrationMigrateCommand::class);
        $application->add($command);

        $commandTester = new CommandTester($application->find('paper:migration:migrate'));
        $exitCode = $commandTester->execute([
        ]);


        $this->assertSame(0, $exitCode, 'Command should return success code 0');
        $this->assertStringContainsString(
            '[INFO] No migrations to run. The database is already up to date.',
            $commandTester->getDisplay()
        );
    }
}
