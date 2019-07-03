<?php
namespace App\Repositories;


class AdminAccountRepository extends BaseRepository
{
    /**
     * @var string
     */
    protected $mainTable = 'admin_accounts';

    /**
     * @return string
     */
    public function model()
    {
        return "App\\Models\\AdminAccount";
    }

}