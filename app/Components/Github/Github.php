<?php

namespace App\Components\Github;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;

class Github implements GithubInterface
{
    /**
     * Git url
     *
     * @var string
     */
    protected $url;

    /**
     * Git API url
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * Git application Client ID
     *
     * @var string
     */
    protected $clientId;
    
    /**
     * Git application Client Secret
     *
     * @var string
     */
    protected $clientSecret;

    /**
     *
     * @var Client
     */
    protected $client;

    /**
     * 
     * @param string $url
     * @param string $apiUrl
     * @param string $clientId
     * @param string $clientSecret
     * @return void
     */
    public function __construct($url, $apiUrl, $clientId, $clientSecret/*, Client $client, $owner, $repo*/)
    {
        $this->url = $url;
        $this->apiUrl = $apiUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->client = app(Client::class);
    }
    
    /**
     * Get authentication link
     * 
     * @return string
     */
    public function authLink()
    {
        return $this->url . '/login/oauth/authorize?client_id=' . $this->clientId;
    }
    
    /**
     * Get user bu token
     * 
     * @param string $token
     * @return array
     */
    public function getUser($token)
    {
        $uri = $this->apiUrl . '/user';
        
        return $this->getBody('GET', $uri, ['headers' => ['Authorization' => 'token ' . $token]]);
    }
    
    /**
     * Get user name by token
     * 
     * @param string $token
     * @return string
     */
    public function getUserName($token)
    {
        $user = $this->getUser($token);
        
        return array_get($user, 'login', '');
    }
    
    /**
     * Get token by responce code
     * 
     * @param string $code
     * @return string
     * 
     * @throws GithubException
     */
    public function getToken($code)
    {
        $res = $this->client->request('post', $this->url . '/login/oauth/access_token', [
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $code,
            ]
        ]);
        
        $res = json_decode($res->getBody()->getContents(), true);
        
        if (array_get($res, 'error_description')) {
            throw new GithubException(array_get($res, 'error_description'));
        }
        
        return array_get($res, 'access_token');
    }
    
    /**
     * Get issues list
     * 
     * @param string $owner
     * @param string $repo
     * @param array $params
     * @return array
     */
    public function issues($owner, $repo, array $params = [])
    {
        $page = array_get($params, 'page') && is_numeric($params['page']) ? $params['page'] : 1;
        $perPage = array_get($params, 'per_page') && is_numeric($params['per_page']) && $params['per_page'] < 100 ? $params['per_page'] : 100;
        $uri = $this->apiUrl . '/repos/' . $owner . '/' . $repo . '/issues?page=' . $page . '&per_page=' . $perPage . '&state=all';
        
        return $this->getBody('GET', $uri);
    }
    
    /**
     * Count issues by state
     * 
     * @param string $owner
     * @param string $repo
     * @param string $state
     * @return string
     */
    public function countIssues($owner, $repo, $state)
    {
        $total = 0;
        $uri = $this->apiUrl . '/repos/' . $owner . '/' . $repo . '/issues?per_page=1&state=' . $state;
        $res = $this->execute('GET', $uri);
        
        $links = array_first($res->getHeader('Link'));
        if ($links) {
            preg_match('/page=(\d+)>; rel="last".*$/', $links, $matches);
            $total = $matches[1];
        }
        
        return $total;
    }
    
    /**
     * Get issue by ID
     * 
     * @param string $owner
     * @param string $repo
     * @param int $id
     * @return array
     */
    public function issue($owner, $repo, $id)
    {
        $uri = $this->apiUrl . '/repos/' . $owner . '/' . $repo . '/issues/' . $id;
        
        return $this->getBody('GET', $uri);
    }
    
    /**
     * Get issue comments list
     * 
     * @param string $owner
     * @param string $repo
     * @param int $id
     * @return array
     */
    public function issueComments($owner, $repo, $id)
    {
        $uri = $this->apiUrl . '/repos/' . $owner . '/' . $repo . '/issues/' . $id . '/comments';
        
        return $this->getBody('GET', $uri);
    }
    
    /**
     * Execute request to API
     * 
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return Response
     * 
     * @throws GithubException
     */
    protected function execute($method, $uri = '', array $options = [])
    {
        try {
            $res = $this->client->request($method, $uri, $options);
            
            return $res;
        } catch (ClientException $exc) {
            switch ($exc->getCode()) {
                case 404:
                    $message = 'Not found';
                    break;
                case 403:
                    $message = 'API rate limit exceeded';
                    break;
                default:
                    $message = $exc->getMessage();
            }
            throw new GithubException($message, $exc->getCode());
        }
    }
    
    /**
     * Execute and get body
     * 
     * @param type $method
     * @param type $uri
     * @param array $options
     * @return array
     */
    protected function getBody($method, $uri = '', array $options = [])
    {
        return $this->getBodyFromResponce($this->execute($method, $uri, $options));
    }
    
    /**
     * Get body from responce
     * 
     * @param Response $res
     * @return array
     */
    protected function getBodyFromResponce(Response $res)
    {
        return json_decode($res->getBody()->getContents());
    }
}
