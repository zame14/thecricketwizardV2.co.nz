<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/10/2018
 * Time: 1:25 PM
 */
class Competition extends CricketWizardBase
{
    public function getType()
    {
        if($this->getPostMeta('competition-type') == 1) {
            return "Limited Overs";
        } else {
            return "Unlimited Overs";
        }
    }
    public function getTeamID()
    {
        return $this->getPostMeta('competition-team-id');
    }
}