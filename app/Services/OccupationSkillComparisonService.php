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
        $flattenedOccupation1 = $this->flattenOccupation($occupation_1);
        // O(N)
        $flattenedOccupation2 = $this->flattenOccupation($occupation_2);

        // we can start from any occupation  to compare
        $attributeMatchCounter = 0;
        $sum = 0;
        $breakdown = [];
        // O(N)
        foreach ($flattenedOccupation1 as $key => $val) {
            if (!array_key_exists($key, $flattenedOccupation2)) {
                continue;
            }
            $match = $this->compareIndividualAttributes($val, $flattenedOccupation2[$key]);
            $attributeMatchCounter++;
            $sum = $sum + $match;
            // payload for break down
            // DTO is better solution than array here :)
            $breakdown[] = ['attribute' => $key,
                'occupation_1' => $val,
                'occupation_2' => $flattenedOccupation2[$key],
                'match' => round($match * 100)
            ];
        }
        // Nothing matched
        if ($attributeMatchCounter === 0) {
            return 0;
        }
        $match = ($sum / $attributeMatchCounter) * 100;
        //TODO: Use DTO
        return ['match' => round($match), 'breakdown' => $breakdown];
    }

    /**
     * @param array $occupation
     *
     * @return array
     */
    private function flattenOccupation(array $occupation)
    {
        $flattenedOccupation = [];
        foreach ($occupation as $key => $val) {
            $flattenedOccupation[$val[1]] = (int)$val[0];
        }

        return $flattenedOccupation;
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