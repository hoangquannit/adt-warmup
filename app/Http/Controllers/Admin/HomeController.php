<?php

namespace App\Http\Controllers\Admin;

use App\Services\AccountService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class HomeController extends Controller
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

    public function index()
    {
        $user = Auth::user();
        return view('index', compact('user'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool|string
     */
    public function editAvatar(Request $request)
    {
        $user = Auth::user();
        $file = $request->file('cover-image');
        $processEdit = $this->accountService->editAvatar($file, $user->id);
        if (!$processEdit) {
            return false;
        }
        return $processEdit;
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $data  = [
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone'),
            'full_name' => $request->get('full_name')];
        $processUpdate = $this->accountService->update($data, $user->id);
        if (!$processUpdate) {
            return redirect()->back()->withErrors(['error_message' => 'error']);
        }
        return redirect()->back()->with(['success_message' => 'update success']);
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}