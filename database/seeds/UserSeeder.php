<?php

use Botble\ACL\Models\User;
use Botble\ACL\Repositories\Interfaces\ActivationInterface;
use Botble\Base\Supports\BaseSeeder;

class UserSeeder extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();

        $user = new User;
        $user->first_name = 'System';
        $user->last_name = 'Admin';
        $user->email = 'admin@facebook.com';
        $user->username = 'botble';
        $user->password = bcrypt('159357');
        $user->super_user = 1;
        $user->manage_supers = 1;
        $user->save();

        event('acl.activating', $user);

        $activationRepository = app(ActivationInterface::class);

        $activation = $activationRepository->createUser($user);

        event('acl.activated', [$user, $activation]);

        return $activationRepository->complete($user, $activation->code);
    }
}
