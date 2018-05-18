<?php

/**
 * PrivacyManager short summary.
 *
 * PrivacyManager description.
 *
 * @version 1.0
 * @author GiantCowFilms
 */
class PrivacyManager
{
    public $requirements = [];

    public $lastError = '';

    public function __construct() {

    }

    public function addPrivacyRequirement($name,$consent_string,$error,$optional = false,$checkLogin = false) {
        $this->requirements[] = [
            "name" => $name,
            "consent_string" => $consent_string,
            "error" => $error,
            "optional" => $optional,
            "field" => 'privacyRequirement-' .  $name
        ];
    }

    public function generateConsentFormSegement() {
        $output = '';
        foreach($this->requirements as $requirement) {
            $output = $output . '<div class="bodyStack"><input name="' .  $requirement["field"] . '" id="privacyRequirement-' .  $requirement["name"] . '"  type="checkbox" />' . $requirement["consent_string"] . '</div>';
        }
        return $output;
    }

    public function verifyConsentFormSegement($form_data) {
        foreach($this->requirements as $requirement) {
            if($form_data[$requirement["field"]] !== 'true') {
                $this->lastError = $requirement;
                return false;
            }
        }
        return true;
    }

}