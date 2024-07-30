<?php

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Services\BusinessRewardService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class BusinessRewardController extends Controller
{
  use JsonResponseTrait;

  protected $businessRewardService;

  public function __construct(BusinessRewardService $businessRewardService)
  {
    $this->businessRewardService = $businessRewardService;
  }

  public function get(Request $request)
  {
    try {
      $company_id = $request->query('company_id');
      $rewards = $this->businessRewardService->getRewards($company_id);

      return $this->successResponse($rewards);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching rewards',
        'REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function show($rewardId)
  {
    try {
      $reward = $this->businessRewardService->getReward($rewardId);
      return $this->successResponse($reward);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching reward',
        'REWARD_NOT_FOUND',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function store(Request $request)
  {
    try {
      $reward = $this->businessRewardService->createReward($request->all());
      return $this->successResponse($reward, null, StatusCode::CREATED);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while creating reward',
        'REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function update(Request $request, $rewardId)
  {
    try {
      $reward = $this->businessRewardService->updateReward($rewardId, $request->all());
      return $this->successResponse($reward);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while updating reward',
        'REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }
}
