<?php

namespace App\Components\Github;

interface GithubInterface
{
    public function authLink();
    
    public function getUser($token);
    
    public function getUserName($token);
    
    public function getToken($code);
    
    public function issues($owner, $repo, array $params = []);
    
    public function countIssues($owner, $repo, $state);
    
    public function issue($owner, $repo, $id);
    
    public function issueComments($owner, $repo, $id);
}
