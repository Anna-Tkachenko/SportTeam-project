<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Repository\User\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for changing status if user is not active at least 15 minutes.
 */
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
        $usersCount = $this->userRepository->getUsersCount() + 100;
        $length = intdiv($usersCount, 100);

        for($counter = 0; $counter < $length; $counter++)
        {
            $users = $this->userRepository->loadUnActiveUser($datetime);
            foreach ($users as $user) {
                $user->setIsActive(false);
                $this->userRepository->save($user);
            }

        }
    }
}
