<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\Github\GithubInterface;
use App\Components\Github\GithubException;
use Illuminate\Pagination\LengthAwarePaginator;

class IssuesController extends Controller
{
    /**
     *
     * @var GithubInterface 
     */
    protected $github;
    
    /**
     * Issues per page
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * 
     * @param GithubInterface $github
     * @return void
     */
    public function __construct(GithubInterface $github)
    {
        $this->middleware('git.auth');
        $this->github = $github;
    }
    
    /**
     * Return issues list with open and closed count
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $owner
     * @param string $repo
     * @return \Illuminate\Http\Response
     */
    public function issues(Request $request, $owner, $repo)
    {
        try {
            $issues = $this->github->issues($owner, $repo, ['page' => $request->page, 'per_page' => $this->perPage]);
            $openCount = $this->github->countIssues($owner, $repo, 'open');
            $closeCount = $this->github->countIssues($owner, $repo, 'closed');
            $issues = new LengthAwarePaginator($issues, $openCount + $closeCount, $this->perPage, $request->page, ['path' => route('git.issues', [$owner, $repo])]);
            
            return view('issues.index', [
                'issues' => $issues,
                'openCount' => $openCount,
                'closeCount' => $closeCount,
                'owner' => $owner,
                'repo' => $repo,
            ]);
        } catch (GithubException $exc) {
            return response($exc->getMessage(), $exc->getCode());
        }
    }
    
    /**
     * Return issue with comments
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $owner
     * @param string $repo
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function issue($owner, $repo, $id)
    {
        try {
            return view('issues.show', [
                'issue' => $this->github->issue($owner, $repo, $id),
                'comments' => $this->github->issueComments($owner, $repo, $id),
                'owner' => $owner,
                'repo' => $repo,
            ]);
        } catch (GithubException $exc) {
            return response($exc->getMessage(), $exc->getCode());
        }
    }
}
