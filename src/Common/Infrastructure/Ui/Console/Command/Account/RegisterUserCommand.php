<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Console\Command\Account;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use TijmenWierenga\Project\Account\Application\Service\User\RegisterUserRequest;
use TijmenWierenga\Project\Account\Application\Service\User\RegisterUserService;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RegisterUserCommand extends Command
{
    /**
     * @var RegisterUserService
     */
    private $service;

    /**
     * RegisterUserCommand constructor.
     * @param RegisterUserService $service
     */
    public function __construct(RegisterUserService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    protected function configure()
    {
        $this->setName('account:register-user')
            ->setDescription('Register a new user')
            ->setHelp('This command creates a new user into the system');

        $this->addArgument('email', InputArgument::REQUIRED, "The user's email address")
            ->addArgument('first-name', InputArgument::REQUIRED, "User's first name")
            ->addArgument('last-name', InputArgument::REQUIRED, "User's last name")
            ->addArgument('password', InputArgument::OPTIONAL, "The user's password");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');

        if (! $password = $input->getArgument('password')) {
            $question = new Question("Select a password");
            $password = $helper->ask($input, $output, $question);
        }

        $request = new RegisterUserRequest(
            $input->getArgument('first-name'),
            $input->getArgument('last-name'),
            $input->getArgument('email'),
            $password
        );

        $this->service->register($request);
        $output->writeln('User was registered');
    }
}
