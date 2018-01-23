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
 * Small article class for a site similar to Medium.
 *
 * This article is a short example of an article class for many blogging sites - specifically I am emulating Medium.
 *
 * @author Mary MacMillan <mschmitt5@cnm.edu>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class article implements \JsonSerializable {
    use ValidateUuid;
    use ValidateDate;

    /**
     * ID for this article. This will be the primary key.
     * @var Uuid $articleId
     **/
    private $articleId;

    /**
     * ID for the profile creating the article. This is a foreign key.
     * @var Uuid $articleProfileId
     **/
    private $articleProfileId;

    /**
     * the actual article text
     *
     * @var string $articleText
     **/
    private $articleText;

    /**
     * title of the article
     *
     * @var string $articleTitle
     **/
    private $articleTitle;

    /**
     * constructor for the article
     *
     * @param Uuid|String $newArticleId
     * @param Uuid|String $newArticleProfileId
     * @param string $newArticleText
     * @param string $newArticleTitle
     *
     * @throws \InvalidArgumentException if data types are not valid or are insecure
     * @throws \RangeException if data values are out of bounds
     * @throws \Exception if some other exception occurs
     * @throws \TypeError if a data type violates a data hint
     **/
    public function __construct($newArticleId, $newArticleProfileId, string $newArticleText, string $newArticleTitle){
        try {
            $this->setArticleId($newArticleId);
            $this->setArticleProfileId($newArticleProfileId);
            $this->setArticleText($newArticleText);
            $this->setArticleTitle($newArticleTitle);
        }
        catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
            //to determine what exception type was thrown
            $exceptionType = get_class($exception);
            throw (new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for article ID
     *
     * @return Uuid value of article ID
     **/
    public function getArticleId() : Uuid {
        return $this->articleId;
    }

    /**
     * mutator method for article ID
     *
     * @param Uuid|String $newArticleId
     * @throws \RangeException if $newArticleId is not positive
     * @throws \TypeError if $newArticleId is not Uuid or string
     **/
    public function setArticleId($newArticleId) : void {
        try {
            $uuid = self::validateUuid($newArticleId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for article profile ID
     *
     * @return Uuid value of article profile ID
     **/
    public function getArticleProfileId() : Uuid {
        return $this->articleProfileId;
    }

    /**
     *mutator method for article profile ID
     *
     * @param Uuid|String $newArticleProfileId
     * @throws \RangeException if $newArticleProfileId is not positive
     * @throws \TypeError if $newArticleProfileId is not Uuid or string
     **/
    public function setArticleProfileId($newArticleProfileId) : void {
        try {
            $uuid = self::validateUuid($newArticleProfileId);
        } catch (\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
            $exceptionType = get_class($exception);
            throw(new $exceptionType($exception->getMessage(), 0, $exception));
        }
    }

    /**
     * accessor method for article text
     *
     * @return string $articleText
     **/
    public function getArticleText() : string {
        return $this->articleText;
    }

    /**
     * mutator method for article text
     *
     * @param string $newArticleText new value or article text
     * @throws \InvalidArgumentException if the $newArticleText is not a string or insecure
     * @throws \RangeException if $newArticleText is > 20000 characters
     * @throws \TypeError if $newArticleText is not a string
     **/
    public function setArticleText(string $newArticleText) : void {
        $newArticleText = trim($newArticleText);
        $newArticleText = filter_var($newArticleText, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if(empty($newArticleText) === true) {
            throw (new \InvalidArgumentException("Article text is empty or insecure"));
        }
        if(strlen($newArticleText) > 20000) {
            throw (new \RangeException("article content is too long"));
        }
            $this->articleText = $newArticleText;

    }

    /**
     * accessor method for article title
     *
     * @return string $articleTitle
     **/
        public function getArticleTitle() : string {
            return $this->articleTitle;
        }

    /**
     * mutator method for article title
     *
     * @param string $newArticleTitle
     * @throws \InvalidArgumentException if the $newArticleTitle is not a string or insecure
     * @throws \RangeException if $newArticleTitle is > 100 characters
     * @throws \TypeError if $newArticleTitle is not a string
     **/
    public function setArticleTitle(string $newArticleTitle) : void {
        $newArticleTitle = trim($newArticleTitle);
        $newArticleTitle = filter_var($newArticleTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        if (empty($newArticleTitle) === true) {
            throw(new \InvalidArgumentException("article title is empty or insecure"));
        }
        if (strlen($newArticleTitle) > 100) {
            throw (new \RangeException("article title is too long"));
        }
        $this->articleTitle = $newArticleTitle;
    }



        /**
         *formats the state variables for JSON serialization
         *
         * @return array resulting state variables to serialize
         **/
        public function jsonSerialize() : array {
            $fields = get_object_vars($this);
            $fields["articleId"] = $this->articleId->toString();
            $fields["articleProfileId"] = $this->articleProfileId->toString();
            return ($fields);
        }
}