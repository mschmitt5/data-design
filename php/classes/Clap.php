<?php
/**
 * Created by PhpStorm.
 * User: schmi
 * Date: 1/21/2018
 * Time: 11:48 AM
 **/

namespace Edu\Cnm\Mschmitt5\DataDesign;
require_once ("autoload.php");
require_once (dirname(__DIR__) . "classes/autoload.php");

use Edu\Cnm\DataDesign\ValidateUuid;
use Edu\Cnm\DataDesign\ValidateDate;
use Ramsey\Uuid\Uuid;
/**
 * Small like/clap class for a site similar to Medium.
 *
 * This clap class is a short example of a like class for some blogging sites - specifically I am emulating Medium. It is different than a usual like because one user can like one article more than once.
 *
 * @author Mary MacMillan <mschmitt5@cnm.edu>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class clap implements \JsonSerializable{
    use ValidateUuid;
    use ValidateDate;

    /**
     * ID for clap. this the primary key
     *
     * @var Uuid $clapId
     **/
    private $clapId;

    /**
     * article ID. this is a foreign key.
     *
     * @var Uuid $clapArticleId
     **/
    private $clapArticleId;

    /**
     * profile ID. this is a foreign key.
     *
     * @var Uuid $clapProfileId
     **/
    private $clapProfileId;

    /**
     * constructor for the clap class
     *
     * @param Uuid|String $newClapId
     * @param Uuid|String $newClapArticleId
     * @param Uuid|String $newClapProfileId
     *
     * @throws \InvalidArgumentException if data types are not valid or are insecure
     * @throws \RangeException if data values are out of bounds
     * @throws \Exception if other exception occurs
     * @throws \TypeError if data type violates a type hint
     **/
    public function __construct($newClapId, $newClapArticleId, $newClapProfileId){
        try {
            $this->setClapId($newClapId);
            $this->setClapArticleId($newClapArticleId);
            $this->setClapProfileId($newClapProfileId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw (new $exceptionType ($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for clap ID
     *
     * @return Uuid value of clap ID
     **/
    public function getClapId() : Uuid {
        return $this->clapId;
    }

    /**
     * mutator method for clap ID
     *
     * @param Uuid|String $newClapId
     *
     * @throws \RangeException if $newClapId is not positive
     * @throws \TypeError if $newClapId is not a uuid or string
     **/
    public function setClapId($newClapId) : void {
        try {
            $uuid = self::validateUuid($newClapId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->$newClapId = $uuid;
    }
    /**
     * accessor method for clap article ID
     *
     * @return Uuid value of clap article ID
     **/
    public function getClapArticleId() : Uuid {
        return $this->clapArticleId;
    }

    /**
     * mutator method for clap article ID
     *
     * @param Uuid|String $newClapArticleId
     *
     * @throws \RangeException if $newClapArticleId is not positive
     * @throws \TypeError if $newClapArticleId is not a uuid or string
     **/
    public function setClapArticleId($newClapArticleId) : void {
        try {
            $uuid = self::validateUuid($newClapArticleId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->$newClapArticleId = $uuid;
    }
    /**
     * accessor method for clap profile ID
     *
     * @return Uuid value of clap profile ID
     **/
    public function getClapProfileId() : Uuid {
        return $this->clapProfileId;
    }

    /**
     * mutator method for clap profile ID
     *
     * @param Uuid|String $newClapProfileId
     *
     * @throws \RangeException if $newClapProfileId is not positive
     * @throws \TypeError if $newClapProfileId is not a uuid or string
     **/
    public function setClapProfileId($newClapProfileId) : void {
        try {
            $uuid = self::validateUuid($newClapProfileId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
        $this->$newClapProfileId = $uuid;
    }

    /**
     * inserts this clap into mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function insert(\PDO $pdo) : void {

        //create query
        $query = "INSERT INTO clap(clapId, clapArticleId, clapProfileId) VALUES(:clapId, :clapArticleId, :clapProfileId)";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holders in the template
        $parameters = ["clapId" => $this->clapId->getBytes(), "clapArticleId" => $this->clapArticleId->getBytes(), "clapProfileId" => $this->clapProfileId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * deletes this clap in mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function delete(\PDO $pdo) : void {

        //create query template
        $query = "DELETE FROM clap WHERE clapId = :clapId";
        $statement = $pdo->prepare($query);

        //bind the member variables to the place holder in the template
        $parameters = ["clapId" => $this->clapId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * updates this clap in mySQL
     *
     * @param \PDO $pdo PDO connection object
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError if $pdo is not a PDO connection object
     **/
    public function update(\PDO $pdo) : void {

        //create query template
        $query = "UPDATE clap SET clapArticleId = :clapArticleId, clapProfileId = :clapProfileId WHERE clapId = :clapId";
        $statement = $pdo->prepare($query);

        $parameters = ["clapId" => $this->clapId->getBytes(), "clapArticleId" => $this->clapArticleId->getBytes(), "clapProfileId" => $this->clapProfileId->getBytes()];
        $statement->execute($parameters);
    }

    /**
     * gets clap by clapId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $clapId clap ID to search for
     *
     * @return Clap|null clap found or null if not found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable is not the correct data type
     **/
    public static function getClapByClapId(\PDO $pdo, $clapId) : ?Clap {

        //sanitize the ClapId before searching
        try {
            $clapId = self::validateUuid($clapId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        //create query template
        $query = "SELECT clapId, clapArticleId, clapProfileId FROM clap WHERE clapId = :clapId";
        $statement = $pdo->prepare($query);

        //bind the clap id to the place holder in the template
        $parameters = ["clapId" => $clapId->getBytes()];
        $statement->execute($parameters);

        //grab the clap from mySQL
        try {
            $clap = null;
            $statement->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $statement->fetch();
            if ($row !== false) {
                $clap = new Clap($row["clapId"], $row["clapArticleId"], $row["clapProfileId"]);
            }
        } catch (\Exception $exception) {
            //if the row couldn't be converted, rethrow it
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }
        return($clap);
    }

    /**
     * gets array of claps by clapArticleId
     *
     * @param \PDO $pdo PDO connection object
     * @param Uuid|string $clapArticleId clap article ID to search for
     *
     * @return \SplFixedArray|null array if found or null if not found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when a variable is not the correct data type
     **/
    public static function getClapsByClapArticleId(\PDO $pdo, $clapArticleId) : \SplFixedArray
    {

        //sanitize the ClapArticleId before searching
        try {
            $clapArticleId = self::validateUuid($clapArticleId);
        } catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            throw (new \PDOException($exception->getMessage(), 0, $exception));
        }

        //create query template
        $query = "SELECT clapId, clapArticleId, clapProfileId FROM clap WHERE clapArticleId = :clapArticleId";
        $statement = $pdo->prepare($query);

        //bind the clap article id to the place holder in the template
        $parameters = ["clapArticleId" => $clapArticleId->getBytes()];
        $statement->execute($parameters);

        //build an array of claps
        $claps = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $clap = new Clap($row["clapId"], $row["clapArticleId"], $row["clapProfileId"]);
                $claps[$claps->key()] = $clap;
                $claps->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
            return ($claps);
        }

    /**
     * gets all claps
     *
     * @param \PDO $pdo PDO connection object
     *
     * @return \SplFixedArray SplFixedArray of claps found or null if not found
     *
     * @throws \PDOException when mySQL related errors occur
     * @throws \TypeError when variables are not the correct data type
     **/
    public static function getAllClaps(\PDO $pdo) : \SplFixedArray {
        //create query template
        $query = "SELECT clapId, clapArticleId, clapProfileId FROM clap";
        $statement = $pdo->prepare($query);
        $statement->execute();

        //build an array of claps
        $claps = new \SplFixedArray($statement->rowCount());
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        while (($row = $statement->fetch()) !== false) {
            try {
                $clap = new Clap($row["clapId"], $row["clapArticleId"], $row["clapProfileId"]);
                $claps[$claps->key()] = $clap;
                $claps->next();
            } catch (\Exception $exception) {
                //if the row couldn't be converted, rethrow it
                throw (new \PDOException($exception->getMessage(), 0, $exception));
            }
        }
        return ($claps);
    }



    /**
     *formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize(): array
    {
        $fields = get_object_vars($this);
        $fields["clapId"] = $this->clapId->toString();
        $fields["clapArticleId"] = $this->clapArticleId->toString();
        $fields["clapProfileId"] = $this->clapProfileId->toString();
        return ($fields);
    }
}