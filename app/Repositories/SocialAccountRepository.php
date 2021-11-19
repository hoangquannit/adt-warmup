<?php
namespace App\Repositories;


class SocialAccountRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $mainTable = 'social_accounts';

    /**
     * @return string
     */
    public function model()
    {
        return "App\\Models\\SocialAccount";
    }

}