<?php

/*
 * This file is part of the "Sport-team" project.
 * (c) Anna Tkachenko <tkachenko.anna835@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Following;

/**
 * Contract for user's follow service.
 *
 * @author Anna Tkachenko <tkachenko.anna835@gmail.com>
 */
interface FollowServiceInterface
{
    public function getFollowing(string $slug);

    public function getFollowers(string $slug);

    public function getUserEntity(string $slug);

    public function follow($currentUser, $user);

    public function unFollow($currentUser, $user): void;
}
