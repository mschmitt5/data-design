<?php
/**
 * Created by PhpStorm.
 * User: schmi
 * Date: 1/21/2018
 * Time: 11:45 AM
 **/

namespace Edu\Cnm\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Small Profile class for a site similar to Medium.
 *
 * This profile is a short example of a general profile class for many sites - specifically I am emulating Medium.
 *
 * @author Mary MacMillan <mschmitt5@cnm.edu>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 *
 **/

class Profile {
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
}

/**
 * accessor method for profile ID
 * @return Uuid value of profile ID
 **/

public function getProfileId() : Uuid {
    return($this->profileId);
}
