<?php
/**
 * Author: josmu
 * Date: 02/11/2018
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class Authentication
{
    private $domain;
    private $headers;

    public function __construct()
    {
        $this->domain = new Domain();
        $this->headers = apache_request_headers();
        //TODO: Check if all headers are set.
    }

    /**
     * Checks if all authentication is set.
     *
     * @return string
     *      If it failes to get through to the authentication then it returns a response json. Otherwise null.
     */
    public function verifyAll()
    {
        $apiKey = $this->getHeaders()["ApiKey"];

        try {
            if (!$this->checkApiKey($apiKey)) {
                return ResponseJson::createFailedResponseMessage("Api key was incorrect");
            }
        } catch (Exception $e) {
            return ResponseJson::createFailedResponseMessage($e->getMessage());
        }

        return null;
    }

    /**
     * Checks if the api key from the user is the same as the key in the database.
     * NOTE: Domain must be set.
     *
     * @param $userKey
     *      The api key from the user.
     * @return bool
     *      Returns true if the id is the same. Otherwise it returns false.
     * @throws NullException
     *      Throws an exception if the domain is not set.
     */
    public function checkApiKey($userKey)
    {
        if ($this->getDomain() == null) {
            Throw new NullException("Domain has not been set.");
        }

        return $this->getDomain()["ApiKey"] == $userKey;
    }

    /**
     * Gets the headers.
     *
     * @return array
     *      Returns the headers in an array.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Gets the domain.
     *
     * @return Domain
     *      The domain in an object.
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the domain by object.
     *
     * @param $userDomain
     *      The domain object that will be set.
     */
    public function setDomain($userDomain)
    {
        $this->domain = $userDomain;
    }

    /**
     * Sets the domain by the given origin.
     *
     * @param $origin
     *      The origin of the domain.
     * @throws ConnectionFailedException
     *      Throws an exception if the connection failed.
     * @throws NullException
     *      Throws an exception if there was no domain found.
     */
    public function setDomainById($origin)
    {
        $this->domain = Db::getSingleRecordByField("domains", "Domain", "origin", $origin);
    }
}