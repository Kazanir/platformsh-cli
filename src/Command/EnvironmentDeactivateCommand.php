<?php

namespace CommerceGuys\Platform\Cli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EnvironmentDeactivateCommand extends EnvironmentCommand
{

    protected function configure()
    {
        $this
            ->setName('environment:deactivate')
            ->setDescription('Deactivate an environment.')
            ->addOption(
                'project',
                null,
                InputOption::VALUE_OPTIONAL,
                'The project id'
            )
            ->addOption(
                'environment',
                null,
                InputOption::VALUE_OPTIONAL,
                'The environment id'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->validateInput($input, $output)) {
            return;
        }
        if (!$this->operationAllowed('deactivate')) {
            $output->writeln("<error>Operation not permitted: The current environment can't be deactivated.</error>");
            return;
        }

        $client = $this->getPlatformClient($this->environment['endpoint']);
        $client->deactivateEnvironment();

        $environmentId = $this->environment['id'];
        $message = '<info>';
        $message .= "\nThe environment $environmentId has been deactivated. \n";
        $message .= "</info>";
        $output->writeln($message);
    }
}
