<?php
/**
 * Created by PhpStorm.
 * User: schmi
 * Date: 1/21/2018
 * Time: 11:45 AM
 **/

namespace Edu\Cnm\Mschmitt5\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__) . "classes/autoload.php");

use function Couchbase\passthruEncoder;
use Edu\Cnm\DataDesign\ValidateUuid;
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

class Profile implements \JsonSerializable {
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
     * constructor for this profile
     *
     * @param string|Uuid $newProfileId
     * @param string $newProfileEmail
     * @param string $newProfileHash
     * @param string $newProfileName
     * @param string $newProfileSalt
     * @param string $newProfileStatement
     *
     * @throws \InvalidArgumentException if data types are not valid or are insecure
     * @throws \RangeException if data values are out of bounds
     * @throws \Exception if some other exception occurs
     * @throws \TypeError if a data type violates a data hint
     **/
    public function __construct($newProfileId, string $newProfileEmail, string $newProfileHash, string $newProfileName, string $newProfileSalt, string $newProfileStatement) {
        try {
            $this->setProfileId($newProfileId);
            $this->setProfileEmail($newProfileEmail);
            $this->setProfileHash($newProfileHash);
            $this->setProfileName($newProfileName);
            $this->setProfileSalt($newProfileSalt);
            $this->setProfileStatement($newProfileStatement);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            //to determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw (new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for profile ID
     * @return Uuid value of profile ID
     **/
    public function getProfileId(): Uuid {
        return $this->profileId;
    }

    /**
     * mutator method for profile ID
     *
     * @param Uuid|string $newProfileId new value of profile ID
     * @throws \RangeException if $newProfileId is not positive
     * @throws \TypeError if $newProfileId is not a uuid or string
     **/
    public function setProfileId($newProfileId): void {
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
    public function getProfileEmail(): string {
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
    public function setProfileEmail($newProfileEmail): void {
        $newProfileEmail = trim($newProfileEmail);
        $newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
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
    public function getProfileHash() : string {
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
    public function setProfileHash(string $newProfileHash): void {
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
    public function getProfileName(): string {
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
    public function setProfileName(string $newProfileName): void {
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
    public function getProfileSalt(): string {
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
    public function setProfileSalt(string $newProfileSalt): void {
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

    public function getProfileStatement() : string {
        return ($this->profileStatement);
    }

    /**
     * mutator method for profile statement
     *
     * @param string $newProfileStatement new value of profile statement
     * @throws \TypeError if $newProfileStatement is not a string
     * @throws \RangeException if $newProfileStatement is > 1000 characters
     **/

    public function setProfileStatement(string $newProfileStatement): void {
        $newProfileStatement = filter_var($newProfileStatement, FILTER_SANITIZE_STRING);
        if (strlen($newProfileStatement) > 1000) {
            throw(new \RangeException("profile statement is too large"));
        }
        $this->profileStatement = $newProfileStatement;
    }

    /**
     * inserts this profile into mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        //create query
        $query = "INSERT INTO profile(profileId, profileEmail, profileHash, profileName, profileSalt, profileStatement) VALUES(:profileId, :profileEmail, :profileHash, :profileName, :profileSalt, :profileStatement)";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holders in the template
        $parameters = ["profileId" => $this->profileId->getBytes(), "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileSalt" => $this->profileSalt, "profileStatement" => $this->profileStatement];
        $statement->execute($parameters);
    }

    /**
     * deletes this profile in mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) : void {

        //create query template
        $query = "DELETE FROM profile WHERE profileId = :profileId";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holder in the template
        $parameters = ["profileId" => $this->profileId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * updates this profile in mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void {

        //create query template
        $query = "UPDATE profile SET profileEmail = :profileEmail, profileHash = :profileHash, profileName = :profileName, profileSalt = :profileSalt, profileStatement = :profileStatement WHERE profileId = :profileId";
        $statement = $pdo->prepare($query);

        $parameters = ["profileId" => $this->profileId->getBytes(), "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileName" => $this->profileName, "profileSalt" => $this->profileSalt, "profileStatement" => $this->profileStatement];
        $statement->execute($parameters);
    }

    /**
     * gets profile by profileId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $profileId profile ID to search for
     *
     * @return Profile|null profile found or null if not found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable is not the correct data type
     **/
    public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {

        //sanitize the profileId before searching
        try {
            $profileId = self::validateUuid($profileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        //create query template
        $query = "SELECT profileId, profileEmail, profileName, profileStatement FROM profile WHERE profileId = :profileId";
        $statement = $pdo->prepare($query);

        //bind the profile id to the place holder in the template
        $parameters = ["profileId" => $profileId->getBytes()];
        $statement->execute($parameters);

        //grab the profile from mySQL
        try {
            $profile = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $profile = new Profile($row["profileId"], $row["profileEmail"], $row["profileName"], $row["profileStatement"]);
            }
        } catch (\Exception $exception) {
            //if the row couldn't be converted, rethrow it
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($profile);
    }

    /**
     * gets profile by profile name
     *
     * @param \PDO $pdo PDO connection object
     * @param string $profileName profile name to search for
     *
     * @return \SplFixedArray SplFixedArray of profiles found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getProfileByProfileName(\PDO $pdo, string $profileName) : \SplFixedArray {
        //sanitize the name before searching
        $profileName = trim($profileName);
        $profileName = filter_var($profileName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($profileName) === true) {
            throw (new \PDOException("profile name is invalid"));
        }

        //escape any mySQL wild cards
        $profileName = str_replace("_", "\\_", str_replace("%", "\\%", $profileName));

        //create query template
        $query = "SELECT profileId, profileEmail, profileName, profileStatement FROM profile WHERE profileName LIKE :profileName";
        $statement = $pdo->prepare($query);

        //bind the profile name to the place holder in the template
        $profileName = "%$profileName%";
        $parameters = ["profileName" => $profileName];
        $statement->execute($parameters);

        //build an array of profiles
        $profiles = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                //required parameter $newProfileSalt is missing???
                $profile = new Profile($row["profileId"], $row["profileEmail"], $row["profileName"], $row["profileStatement"]);
                $profiles[$profiles->key()] = $profile;
                $profiles->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return($profiles);
    }

    /**
     * gets all profiles
     *
     * @param \PDO $pdo PDO connection object
     *
     * @return \SplFixedArray SplFixedArray of profiles found or null if not found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getAllProfiles(\PDO $pdo) : \SplFixedArray {
        //create query template
        $query = "SELECT profileId, profileEmail, profileName, profileStatement FROM profile";
        $statement = $pdo->prepare($query);
        $statement->execute();

        //build an array of profiles
        $profiles = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $profile = new Profile($row["profileId"], $row["profileEmail"], $row["profileName"], $row["profileStatement"]);
                $profiles[$profiles->key()] = $profile;
                $profiles->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($profiles);
    }


    /**
     *formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize()
    {
        $fields = get_object_vars($this);
        $fields["profileId"] = $this->profileId->toString();
        unset($fields["profileHash"]);
        unset($fields["profileSalt"]);
        return ($fields);
    }
}

