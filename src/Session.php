<?php

namespace LuckPermsAPI;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use LuckPermsAPI\Exception\LuckPermsConnectionException;
use LuckPermsAPI\Group\GroupRepository;
use LuckPermsAPI\User\UserRepository;

class Session {

    public HttpClient $httpClient;

    /**
     * @throws LuckPermsConnectionException
     */
    public function __construct(HttpClient $httpClient) {
        $this->httpClient = $httpClient;

        $this->validateConnection();
    }

    /**
     * @throws LuckPermsConnectionException
     */
    private function validateConnection(): void {
        try {
            $this->httpClient->get('/');
        } catch (GuzzleException $e) {
            throw new LuckPermsConnectionException("Could not connect to LuckPerms API: {$e->getMessage()}");
        }
    }

    public function userRepository(): UserRepository {
        return UserRepository::get($this);
    }

    public function groupRepository(): GroupRepository {
        return GroupRepository::get($this);
    }

}
