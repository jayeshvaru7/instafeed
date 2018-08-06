<?php

/*
 * This file is part of Instagram.
 *
 * (c) Jayesh Varu <jayesh@tingmail.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Jvaru\Instagram;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

/**
 * This is the instagram class.
 *
 * @author Jayesh Varu <jayesh@tingmail.in>
 */
class Instagram
{
    /**
     * The access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * The http client.
     *
     * @var \Http\Client\HttpClient
     */
    protected $httpClient;

    /**
     * The http request factory.
     *
     * @var \Http\Message\RequestFactory
     */
    protected $requestFactory;

    /**
     * Create a new instagram instance.
     *
     * @param string $accessToken
     * @param \Http\Client\HttpClient|null $httpClient
     * @param \Http\Message\RequestFactory|null $requestFactory
     *
     * @return void
     */
    public function __construct(string $accessToken, HttpClient $httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->accessToken = $accessToken;
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Fetch user information.
     *
     * @return object
     */
    public function self(): array
    {
        // $response = $this->get('users/self&');
       $url = 'https://api.instagram.com/v1/users/self/?&access_token='.$this->accessToken;
        // $response = $this->get('users/self/media/recent&');
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return (array)$body;
    }

	//Fetch user's media
	public function media(): array
    {
		$url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$this->accessToken;
        
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return $body->data;
		
    }
	
	//Get information about a location.
	public function loc_by_id($loc_id): array
    {
		$url = 'https://api.instagram.com/v1/locations/'.$loc_id.'/?access_token='.$this->accessToken;
        
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return (array)$body->data;
		
    }
	
	// Get a list of recent media objects from a given location.
	public function media_by_loc_id($loc_id): array
    {
		$url = 'https://www.instagram.com/explore/locations/'.$loc_id.'/?__a=1&max_id=10';
		// $url = 'https://api.instagram.com/v1/locations/'.$loc_id.'/media/recent?access_token='.$this->accessToken;
        
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return (array)$body;
		
    }

	// Media in that lat and long
    public function media_lat_long($lat,$long): array
    {
		$url = 'https://api.instagram.com/v1/media/search?lat='.$lat.'&lng='.$long.'&access_token='.$this->accessToken;
        
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return $body->data;
		
    }
	
	//Get information about a tag object.
	public function tags($tag_name): array
    {
		$url = 'https://api.instagram.com/v1/tags/search?q='.$tag_name.'&access_token='.$this->accessToken;
        // $response = $this->get('tags/search?q='.$tag_name.'&');
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return $body->data;
    }
	
	// Get a list of recently tagged media of key owner.
	public function tag_media($tag_name): array
    {
        $url = 'https://api.instagram.com/v1/tags/'.$tag_name.'/media/recent?access_token='.$this->accessToken;
        $request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return $body->data;
    }
	
	// Explore media by tags .
	public function mediabytag($tag_name,$max_id): array
    {
		$url = 'https://www.instagram.com/explore/tags/'.$tag_name.'/?__a=1&max_id='.$max_id;
		$request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return (array)$body;
    }
	
	public function general_search($param): array
    {
        $url = 'https://www.instagram.com/web/search/topsearch/?query='.$param;
        $request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return (array)$body;
    }	
	
	
    /**
     * Fetch the items.
     *
     * @throws \jvaru\Instagram\InstagramException
     *
     * @return array
     */
    protected function get(string $url): array
    {
        // $url = sprintf('https://api.instagram.com/v1/%saccess_token=%s', $path, $this->accessToken);
		
        $request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->httpClient->sendRequest($request);
        $body = json_decode((string) $response->getBody());
        if (isset($body->error_message)) {
            throw new InstagramException($body->error_message);
        }
        if (isset($body->meta->error_message)) {
            throw new InstagramException($body->meta->error_message);
        }
        return $body;
    }
	
	    public function dummy(): array
    {
        $uri = sprintf('https://api.instagram.com/v1/tags/bike/media/recent?access_token=%s', $this->accessToken);

        $request = $this->requestFactory->createRequest('GET', $uri);

        $response = $this->httpClient->sendRequest($request);

        if ($response->getStatusCode() === 400) {
            $body = json_decode((string) $response->getBody());

            throw new InstagramException($body->meta->error_message);
        }

        return json_decode((string) $response->getBody())->data;
    }
}
