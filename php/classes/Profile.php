<?php
/**
 * Created by PhpStorm.
 * User: schmi
 * Date: 1/21/2018
 * Time: 11:45 AM
 **/

namespace Edu\Cnm\Mschmitt5\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "classes/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Small Profile class for a site similar to Medium.
 *
 * This profile is a short example of a general profile class for many blogging sites - specifically I am emulating Medium.
 *
 * @author Mary MacMillan <mschmitt5@cnm.edu>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class Profile implements \JsonSerializable
{
    use ValidateUuid;
    /**
     * ID for this profile. This will be the primary key.
     * @var Uuid $profileId
     **/
    private $profileId;
    /**
     * email for the profile
     * @var string $profileEmail
     **/
    private $profileEmail;
    /**
     * hash for validating password
     * @var $profileHash
     **/
    private $profileHash;
    /**
     * Name attached to this profile.
     * @var string $profileName
     **/
    private $profileName;
    /**
     * salt for validating password
     * @var $profileSalt
     **/
    private $profileSalt;
    /**
     * "about me" section of the profile.
     * @var string $profileStatement
     **/
    private $profileStatement;

    /**
     * accessor method for profile ID
     * @return Uuid value of profile ID
     **/

    public function getProfileId(): Uuid
    {
        return $this->profileId;
    }

    /**
     * mutator method for profile ID
     *
     * @param Uuid| string $newProfileId new value of profile ID
     * @throws \RangeException if $newProfileId is not positive
     * @throws \TypeError if $newProfileId is not a uuid or string
     **/
    public function setProfileId($newProfileId): void
    {
        try {
            $uuid = self::validateUuid($newProfileId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        /**
         * convert and store the profile ID
         **/
        $this->profileId = $uuid;
    }

    /**
     *accessor method for profile email
     * @return string value of profile email
     **/

    public function getProfileEmail(): string
    {
        return ($this->profileEmail);
    }

    /**
     * mutator method for profile email
     *
     * @param string $newProfileEmail new value of profile email
     * @throws \RangeException if $newProfileEmail is > 120 characters
     * @throws \TypeError if $newProfileEmail is not a string
     * @throws \InvalidArgumentException if $newProfileEmail is invalid or insecure
     **/

    public function setProfileEmail($newProfileEmail): void
    {
        $newProfileEmail = trim($newProfileEmail);
        $newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
        if (empty($newProfileEmail) === true) {
            throw(new \InvalidArgumentException("profile email is empty or insecure"));
        }
        if (strlen($newProfileEmail) > 128) {
            throw(new \RangeException("profile email is too large"));
        }
        $this->profileEmail = $newProfileEmail;
    }

    /**
     * accessor method for profileHash
     * @return string value of profile hash
     **/

    public function getProfileHash()
    {
        return ($this->profileHash);
    }

    /**
     * mutator method for profile hash
     *
     * @param $newProfileHash
     * @throws \InvalidArgumentException if the hash is not secure
     * @throws \RangeException if the hash is not 128 characters
     * @throws \TypeError if profile hash is not a string
     **/
    public function setProfileHash(string $newProfileHash): void
    {
        $newProfileHash = trim($newProfileHash);
        $newProfileHash = strtolower($newProfileHash);
        if (empty($newProfileHash) === true) {
            throw(new \InvalidArgumentException("profile hash empty or insecure"));
        }
        if (!ctype_xdigit($newProfileHash)) {
            throw(new \RangeException("profile hash must be 128 characters"));
        }
        $this->profileHash = $newProfileHash;
    }

    /**
     * accessor method for profile name
     *
     * @return string value of profile name
     **/
    public function getProfileName(): string
    {
        return ($this->profileName);
    }

    /**
     * mutator method for profile name
     *
     * @param string $newProfileName new value of profile name
     * @throws \InvalidArgumentException if $newProfileName is not a string or is insecure
     * @throws \TypeError if $newProfileName is not a string
     * @throws \RangeException if $newProfileName is > 32 characters
     **/
    public function setProfileName(string $newProfileName): void
    {
        $newProfileName = trim($newProfileName);
        $newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newProfileName) === true) {
            throw(new \InvalidArgumentException("profile name is empty or insecure"));
        }

        if (strlen($newProfileName) > 32) {
            throw(new \RangeException("profile name is too large"));
        }
        $this->profileName = $newProfileName;
    }

    /**
     *accessor method for profile salt
     *
     * @return string value of the salt
     **/
    public function getProfileSalt(): string
    {
        return $this->profileSalt;
    }

    /**
     * mutator method for profile salt
     *
     * @param string $newProfileSalt
     * @throws \InvalidArgumentException if the salt is not secure
     * @throws \RangeException if the salt is not 64 characters
     * @throws \TypeError if the profile salt is not a string
     **/
    public function setProfileSalt(string $newProfileSalt): void
    {
        $newProfileSalt = trim($newProfileSalt);
        $newProfileSalt = strtolower($newProfileSalt);
        if (!ctype_xdigit($newProfileSalt)) {
            throw(new \InvalidArgumentException("profile password salt is empty or insecure"));
        }
        if (strlen($newProfileSalt) !== 64) {
            throw(new \RangeException("profile salt must be 128 characters"));
        }
        $this->profileSalt = $newProfileSalt;
    }

    /**
     * accessor method for profile statement
     *
     * @return string value of profile statement
     **/

    public function getProfileStatement()
    {
        return ($this->profileStatement);
    }

    /**
     * mutator method for profile statement
     *
     * @param string $newProfileStatement new value of profile statement
     * @throws \TypeError if $newProfileStatement is not a string
     * @throws \RangeException if $newProfileStatement is > 1000 characters
     **/

    public function setProfileStatemet(string $newProfileStatement): void
    {
        $newProfileStatement = filter_var($newProfileStatement, FILTER_SANITIZE_STRING);
        if (strlen($newProfileStatement) > 1000) {
            throw(new \RangeException("profile statement is too large"));
        }
        $this->profileStatment = $newProfileStatement;
    }
}
