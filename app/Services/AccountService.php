<?php

namespace App\Services;

use App\Models\AdminAccount;
use App\Models\SocialAccount;
use App\Repositories\AdminAccountRepository;
use App\Repositories\SocialAccountRepository;
use Laravel\Socialite\Contracts\User as ProviderUser;


class AccountService
{
    /**
     * @var AdminAccountRepository
     */
    protected $adminAccountRepository;

    /**
     * @var SocialAccountRepository
     */
    protected $socialAccountRepository;

    /**
     * AccountService constructor.
     * @param AdminAccountRepository $accountRepository
     * @param SocialAccountRepository $socialAccountRepository
     */
    public function __construct(
        AdminAccountRepository $accountRepository,
        SocialAccountRepository $socialAccountRepository
    ){
        $this->adminAccountRepository  = $accountRepository;
        $this->socialAccountRepository = $socialAccountRepository;
    }
    /**
     * @param ProviderUser $user
     * @param $social
     * @return mixed
     */
    public function createOrGetUser(ProviderUser $user, $social)
    {
        $account = $this->socialAccountRepository->findByField('provider_admin_id', $user->getId())->first();

        if ($account) {
            return $account->adminAccount;
        } else {
            $email = $user->getEmail();

            $adminAccount = $this->adminAccountRepository->findByField('email', $email)->first();
            if (!$adminAccount) {
                $adminAccount = $this->adminAccountRepository->create([
                    'email'     => $email,
                    'full_name' => $user->getName(),
                    'password'  => bcrypt($user->getName()),
                ]);
            }

            $account = [
                'provider_admin_id' => $user->getId(),
                'provider'          => $social,
                'admin_id'          => $adminAccount->id
            ];

            $this->socialAccountRepository->create($account);

            return $adminAccount;
        }
    }

    /**
     * @param $file
     * @param $id
     * @return bool|string
     */
    public function editAvatar($file, $id)
    {
        try {
            $data = file_get_contents($file);
            $type = pathinfo($file, PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            $file = ['avatar' => $base64];
            $this->adminAccountRepository->update(['id'=> $id], $file);

            return $base64;
        } catch (\Exception $e) {
            return false;
        }

    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function update($data, $id)
    {
        try {
            $this->adminAccountRepository->update(['id'=> $id], $data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}