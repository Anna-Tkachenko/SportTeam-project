<?php

namespace App\Command;

use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class VerifyUserStatusCommand extends Command
{
    private $userRepository;
    protected static $defaultName = 'app:verify-user-status';

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Monitors user active status.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $datetime = new \DateTime();
        $datetime = $datetime->sub(new \DateInterval('PT15M'));

        $users = $this->userRepository->loadUnActiveUser($datetime);

        foreach ($users as $user) {
            $user->setIsActive(false);
            $this->userRepository->save($user);
        }

    }
}
