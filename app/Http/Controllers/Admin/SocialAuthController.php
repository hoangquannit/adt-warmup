<?php

namespace App\Http\Controllers\Admin;

use App\Services\AccountService;
use App\Http\Controllers\Controller;
use Socialite, Auth;

class SocialAuthController extends Controller
{
    /**
     * @var AccountService
     */
    protected $accountService;

    /**
     * SocialAuthController constructor.
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    /**
     * @param $social
     * @return mixed
     */
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    /**
     * @param $social
     * @return mixed
     */
    public function handleProviderCallback($social)
    {
        $user = Socialite::driver($social)->user();
        
        $authUser = $this->accountService->createOrGetUser($user, $social);

        Auth::login($authUser, true);
        
        return redirect()->route('home');
    }
}
