<?php

namespace App\Services;

use App\Models\Point;
use App\Models\PointTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PointService
{
  public function getPoints($userId)
  {
    return Point::where('user_id', $userId)->firstOrFail();
  }

  public function getPointsHistory($userId)
  {
    try {
      $point = Point::where('user_id', $userId)->firstOrFail();
      $transactions = $point->pointTransactions()
        ->with('reward')
        ->orderBy('created_at', 'desc')
        ->get();
      return $transactions;
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      throw $e;
    }
  }

  public function createPoint($data)
  {
    try {
      return Point::create($data);
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      throw $e;
    }
  }

  public function updatePoint($userId, $type, $points, $consumerPickupId = null, $rewardId = null)
  {
    DB::beginTransaction();
    try {
      $point = Point::where('user_id', $userId)->firstOrFail();
      $new_points = $type === 'earn' ?
        $point->point + $points :
        $point->point - $points;

      $transaction = PointTransaction::create([
        'point_id' => $point->id,
        'transaction_type' => $type,
        'point' => $points,
        'consumer_pickup_id' => $consumerPickupId,
        'reward_id' => $rewardId,
      ]);

      $point->update([
        'point' => $new_points,
      ]);

      DB::commit();
      return ['point' => $point, 'transaction' => $transaction];
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }
}
