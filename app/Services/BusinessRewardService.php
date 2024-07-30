<?php

namespace App\Services;

use App\Models\Reward;
use Illuminate\Support\Facades\DB;

class BusinessRewardService
{
  public function getRewards($company_id)
  {
    return Reward::where('company_id', $company_id)->get();
  }

  public function getReward($rewardId)
  {
    return Reward::findOrFail($rewardId);
  }

  public function createReward($data)
  {
    DB::beginTransaction();
    try {
      $reward = Reward::create($data);
      DB::commit();

      return $reward;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function updateReward($rewardId, $data)
  {
    DB::beginTransaction();
    try {
      $reward = Reward::findOrFail($rewardId);
      $reward->update($data);
      DB::commit();

      return $reward;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
