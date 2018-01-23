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

class article implements \JsonSerializable{
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
     *formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize(): array
    {
        $fields = get_object_vars($this);
        $fields["clapId"] = $this->clapId->toString();
        $fields["articleId"] = $this->clapArticleId->toString();
        $fields["articleProfileId"] = $this->clapProfileId->toString();
        return ($fields);
    }
}