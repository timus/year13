<?php

namespace App\Services;

use App\Contracts\OccupationParser;
use App\Contracts\OccupationSkillComparisonServiceInterface;

/**
 * Class OccupationSkillComparisonService
 * @package App\Services
 */
class OccupationSkillComparisonService implements OccupationSkillComparisonServiceInterface
{
    /**
     * @var OccupationParser
     */
    private $parser;

    /**
     * OccupationService constructor.
     *
     * @param OccupationParser $parser
     */
    public function __construct(OccupationParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @inheritDoc
     */
    public function listOccupation()
    {
        return $this->parser->list();
    }

    /**
     * @inheritDoc
     */
    public function getOccupationSkills(string $occupationCode)
    {
        return $this->parser->get($occupationCode);
    }

    /**
     * @inheritDoc
     */
    public function compare(array $occupation_1, array $occupation_2)
    {
        // O(N)
        $flattened_occupation1 = $this->flattenOccupation($occupation_1);
        // O(N)
        $flattened_occupation2 = $this->flattenOccupation($occupation_2);

        // we can start from any occupation  to compare
        $attributeMatchCounter = 0;
        $sum = 0;
        // O(N)
        foreach ($flattened_occupation1 as $key => $val) {
            if (!array_key_exists($key, $flattened_occupation2)) {
                continue;
            }
            $match = $this->compareIndividualAttributes($val, $flattened_occupation2[$key]);
            $attributeMatchCounter++;
            $sum = $sum + $match;
        }
        $match =  ($sum / $attributeMatchCounter) * 100;

        return round($match);
    }

    /**
     * @param array $occupation
     *
     * @return array
     */
    private function flattenOccupation(array $occupation)
    {
        $flattened_occupation = [];
        foreach ($occupation as $key => $val) {
            $flattened_occupation[$val[1]] = (int)$val[0];
        }

        return $flattened_occupation;
    }

    /**
     * @param int $val1
     * @param int $val2
     *
     * @return float|int
     */
    private function compareIndividualAttributes(int $val1, int $val2)
    {
        if ($val1 === $val2) {
            $match = 1;
        } else if ($val1 > $val2) {
            $match = $val2 / $val1;
        } else {
            $match = $val1 / $val2;
        }

        return $match;
    }

    /**
     * @inheritDoc
     */
    public function setSkillsScope()
    {
        $this->parser->setScope('skills');
    }
}