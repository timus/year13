<?php

namespace App\Contracts;

interface OccupationSkillComparisonServiceInterface
{
    /**
     * @return array
     */
    public function listOccupation();

    /**
     * @param string $occupationCode
     *
     * @return array
     */
    public function getOccupationSkills(string $occupationCode);

    /**
     * @param array $occupation_1
     * @param array $occupation_2
     *
     * @return float|int
     */
    public function compare(array $occupation_1, array $occupation_2);

    /**
     * @return void
     */
    public function setSkillsScope();

}