<?php
/**
 * Author: josmu
 * Date: 02/11/2018
 */

class Authentication
{
    private $domain;

    public function __construct()
    {
        $this->domain = new Domain();
    }

    /**
     * Checks if the api key from the user is the same as the key in the database.
     * NOTE: Domain must be set.
     *
     * @param $userKey
     *      The api key from the user.
     * @return bool
     *      Returns true if the id is the same. Otherwise it returns false.
     * @throws NotSetException
     *      Throws an exception if the domain is not set.
     */
    public function checkApiKey($userKey)
    {
        if ($this->getDomain() == null) {
            Throw new NotSetException("Domain has not been set.");
        }

        return $this->getDomain()->ApiKey == $userKey;
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
        $this->domain = Db::getSingleRecordByField("domain", "Domain", "origin", $origin);
    }
}