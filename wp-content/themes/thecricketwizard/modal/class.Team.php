<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 4/3/2018
 * Time: 9:50 PM
 */
class Team extends CricketWizardBase
{
    public function getProvince()
    {
        return $this->getPostMeta('province');
    }
    public function getCountry()
    {
        return $this->getPostMeta('country');
    }
    public function getGrade()
    {
        return $this->getPostMeta('grade');
    }
}