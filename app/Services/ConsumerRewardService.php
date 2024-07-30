<?php

namespace App\Services;

use App\Helpers\CodeGenerator;
use App\Models\RedeemedReward;
use App\Models\Reward;
use Illuminate\Support\Facades\DB;

class ConsumerRewardService
{
  public function getRewards()
  {
    $currentDateTime = now();

    $activeRewards = Reward::where('start_time', '<=', $currentDateTime)
      ->where('end_time', '>=', $currentDateTime)
      ->get();

    $upcomingRewards = Reward::where('start_time', '>', $currentDateTime)
      ->get();

    return [
      'active' => $activeRewards,
      'upcoming' => $upcomingRewards,
    ];
  }

  public function getReward($rewardId)
  {
    return Reward::findOrFail($rewardId);
  }

  public function getRedeems($userId)
  {
    return RedeemedReward::where('user_id', $userId)->with('reward')->get();
  }

  public function getRedeem($redeemId)
  {
    return RedeemedReward::with('reward')
      ->findOrFail($redeemId);
  }

  public function redeem($rewardId, $data)
  {
    DB::beginTransaction();
    try {
      $redeem_code = CodeGenerator::generateRandomCode();

      $redeemded_reward = RedeemedReward::create([
        'user_id' => $data['user_id'],
        'reward_id' => $rewardId,
        'redeemed_at' => now(),
        'reference_code' => $redeem_code,
      ]);

      DB::commit();
      return $redeemded_reward;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function use($redeemId)
  {
    DB::beginTransaction();
    try {
      $redeemed_reward = RedeemedReward::findOrFail($redeemId);
      $redeemed_reward->update([
        'used_at' => now(),
      ]);

      DB::commit();
      return $redeemed_reward;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
