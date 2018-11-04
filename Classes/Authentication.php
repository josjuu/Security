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
    public $headers;

    public function __construct()
    {
        $this->domain = new Domain();
        $this->headers = apache_request_headers();
    }

    /**
     * Checks if all authentication is set.
     */
    public function verifyApiKey()
    {
        $apiKey = $this->headers["ApiKey"];
        $response = null;

        try {
            if (!$this->checkApiKey($apiKey)) {
                $response = ResponseJson::createFailedResponseMessage("Api key was incorrect");
            }
        } catch (Exception $e) {
            $response = ResponseJson::createFailedResponseMessage($e->getMessage());
        }

        if (isset($response)) {
            echo $response;
            exit();
        }
    }

    public function verifyLevel()
    {
        $restMethod = $_SERVER['REQUEST_METHOD'];
        $response = null;

        try {
            if (!$this->checkLevel($restMethod)) {
                $response = ResponseJson::createFailedResponseMessage("No authorization for this request");
            }
        } catch (NullException $e) {
            $response = ResponseJson::createFailedResponseMessage($e->getMessage());
        }

        if (isset($response)) {
            echo $response;
            exit();
        }
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
     */
    public function setDomainById($origin)
    {
        try {
            $this->domain = Db::getSingleRecordByField("domains", "Domain", "origin", $origin);
        } catch (NullException $e) {
            echo ResponseJson::createFailedResponseMessage("Origin not found.");
            exit();
        } catch (Exception $e) {
            echo ResponseJson::createFailedResponseMessage($e->getMessage());
            exit();
        }
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
    private function checkApiKey($userKey)
    {
        if ($this->getDomain() == null) {
            Throw new NullException("Domain has not been set.");
        }

        return $this->getDomain()["ApiKey"] == $userKey;
    }

    /**
     * Checks if the domain has a high enough level to do the rest method.
     * NOTE: Domain must be set.
     *
     * @param $restMethod
     *      The method of the api level.
     *      This is GET, POST, PUT or DELETE.
     * @return bool
     *      Returns true if it can access the method.
     * @throws NullException
     *      Throws an exception if the domain is not set.
     */
    private function checkLevel($restMethod)
    {
        if ($this->getDomain() == null) {
            Throw new NullException("Domain has not been set.");
        }

        $methodLevel = self::getMethodLevel($restMethod);

        return $methodLevel <= $this->getDomain()["Level"];
    }

    /**
     * Gets the level of the rest method.
     *
     * @param $restMethod
     *      The rest method of which you want the level of.
     * @return int
     *      Returns the level of the method.
     */
    private function getMethodLevel($restMethod)
    {
        if ($restMethod == "GET") {
            return 1;
        } else if ($restMethod == "POST" || $restMethod == "PUT") {
            return 2;
        } else if ($restMethod == "DELETE") {
            return 3;
        } else {
            return 99;
        }
    }
}