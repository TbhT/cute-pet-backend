<?php


namespace app\storage;


class JwtAccessToken extends \OAuth2\Storage\JwtAccessToken
{
    public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = null)
    {
        return parent::setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope); // TODO: Change the autogenerated stub
    }

    public function unsetAccessToken($access_token)
    {
        return parent::unsetAccessToken($access_token); // TODO: Change the autogenerated stub
    }
}