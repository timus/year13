<?php

namespace App\Http\Controllers;

use App\Services\OccupationSkillComparisonService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class OccupationsController
 * @package App\Http\Controllers
 */
class OccupationsController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var OccupationSkillComparisonService
     */
    private $occupationSkillComparisonService;

    /**
     * OccupationsController constructor.
     *
     * @param OccupationSkillComparisonService $occupationSkillComparisonService
     */
    public function __construct(OccupationSkillComparisonService $occupationSkillComparisonService)
    {
        $this->occupationSkillComparisonService = $occupationSkillComparisonService;
    }

    /**
     * @return array
     */
    public function index()
    {
        return $this->occupationSkillComparisonService->listOccupation();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function compare(Request $request)
    {
        $this->occupationSkillComparisonService->setSkillsScope();
        $occupation_1 = $this->occupationSkillComparisonService->getOccupationSkills($request->get('occupation_1'));
        $occupation_2 = $this->occupationSkillComparisonService->getOccupationSkills($request->get('occupation_2'));
        $matchPayload = $this->occupationSkillComparisonService->compare($occupation_1, $occupation_2);

        return $matchPayload;

    }

}
