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
 * This profile is a short example of an article class for many blogging sites - specifically I am emulating Medium.
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
     *formats the state variables for JSON serialization
     *
     * @return array resulting state variables to serialize
     **/
    public function jsonSerialize(): array
    {
        $fields = get_object_vars($this);
        $fields["clapId"] = $this->clapId->toString();
        $fields["articleId"] = $this->articleId->toString();
        $fields["articleProfileId"] = $this->articleProfileId->toString();
        return ($fields);
    }
}