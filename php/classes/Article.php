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

/**
 * Small article class for a site similar to Medium.
 *
 * This profile is a short example of an article class for many blogging sites - specifically I am emulating Medium.
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
     * @var Uuid $profileId
     **/
    private $profileId;

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
     * @param Uuid|String $newProfileId
     * @param string $newArticleText
     * @param string $newArticleTitle
     *
     * @throws \InvalidArgumentException if data types are not valid or are insecure
     * @throws \RangeException if data values are out of bounds
     * @throws \Exception if some other exception occurs
     * @throws \TypeError if a data type violates a data hint
     **/

}