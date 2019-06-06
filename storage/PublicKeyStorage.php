<?php


namespace app\storage;


use OAuth2\Storage\PublicKeyInterface;

class PublicKeyStorage implements PublicKeyInterface
{

    private $pvk;
    private $pbk;

    public function __construct()
    {
        $this->pbk = file_get_contents('privatekey.pem', true);
        $this->pvk = file_get_contents('publickey.pem', true);
    }

    /**
     * @param mixed $client_id
     * @return mixed
     */
    public function getPublicKey($client_id = null)
    {
        return $this->pbk;
    }

    /**
     * @param mixed $client_id
     * @return mixed
     */
    public function getPrivateKey($client_id = null)
    {
        return $this->pvk;
    }

    /**
     * @param mixed $client_id
     * @return mixed
     */
    public function getEncryptionAlgorithm($client_id = null)
    {
        return 'HS256';
    }
}