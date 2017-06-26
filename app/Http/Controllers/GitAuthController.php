<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Github\GithubInterface;
use App\Components\Github\GithubException;

class GitAuthController extends Controller
{
    /**
     *
     * @var GithubInterface 
     */
    protected $github;

    /**
     * 
     * @param GithubInterface $github
     * @return void
     */
    public function __construct(GithubInterface $github)
    {
        $this->middleware('git.guest', ['except' => ['logout']]);
        $this->github = $github;
    }

    /**
     * Show login page
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        return view('layouts.login', ['loginUrl' => $this->github->authLink()]);
    }
    
    /**
     * Handle callback redirect from github
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request)
    {
        try {
            $token = $this->github->getToken($request->code);
            session([config('github.token_key') => $token]);
            return redirect('/');
        } catch (GithubException $exc) {
            return redirect(route('git.login'))->with('error', $exc->getMessage());
        }
    }
    
    /**
     * Log out user
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->session()->forget(config('github.token_key'));
        
        return redirect(route('git.login'));
    }
}
