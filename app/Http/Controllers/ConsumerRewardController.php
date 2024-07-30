<?php

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Services\ConsumerRewardService;
use App\Services\PointService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class ConsumerRewardController extends Controller
{
  use JsonResponseTrait;

  protected $consumerRewardService;
  protected $pointService;

  public function __construct(ConsumerRewardService $consumerRewardService, PointService $pointService)
  {
    $this->consumerRewardService = $consumerRewardService;
    $this->pointService = $pointService;
  }

  public function get()
  {
    try {
      $rewards = $this->consumerRewardService->getRewards();
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
      $reward = $this->consumerRewardService->getReward($rewardId);
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

  public function getRedeems($userId)
  {
    try {
      $redeemed_rewards = $this->consumerRewardService->getRedeems($userId);
      return $this->successResponse($redeemed_rewards);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching redeemed rewards',
        'REDEEMED_REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function getRedeem($redeemId)
  {
    try {
      $redeemed_reward = $this->consumerRewardService->getRedeem($redeemId);
      return $this->successResponse($redeemed_reward);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching redeemed reward',
        'REDEEMED_REWARD_NOT_FOUND',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function redeem(Request $request, $rewardId)
  {
    try {
      $user_id = $request->input('user_id');
      $reward = $this->consumerRewardService->getReward($rewardId);
      $point = $this->pointService->updatePoint($user_id, 'spend', $reward->required_points, null, $reward->id);
      $redeem_reward = $this->consumerRewardService->redeem($rewardId, $request->all());

      return $this->successResponse($redeem_reward);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while creating reward',
        'REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function use($redeemId)
  {
    try {
      $redeem_reward = $this->consumerRewardService->use($redeemId);
      return $this->successResponse($redeem_reward);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while using reward',
        'REDEEMED_REWARD_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }
}
