<?php

namespace App\Http\Controllers;

use App\Http\StatusCode;
use App\Services\PointService;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\Request;

class PointController extends Controller
{
  use JsonResponseTrait;

  protected $pointService;

  public function __construct(PointService $pointService)
  {
    $this->pointService = $pointService;
  }

  public function show($userId)
  {
    try {
      $points = $this->pointService->getPoints($userId);
      return $this->successResponse($points);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching points',
        'POINT_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function history($userId)
  {
    try {
      $points = $this->pointService->getPointsHistory($userId);
      return $this->successResponse($points);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while fetching points history',
        'POINT_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function store(Request $request)
  {
    try {
      $this->pointService->createPoint($request->all());
      return $this->successResponse([], 'Point created successfully', StatusCode::CREATED);
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while creating point',
        'POINT_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }

  public function update(Request $request, $userId)
  {
    try {
      $type = $request->input('type');
      $points = $request->input('points');
      $pickupId = $request->input('consumer_pickup_id');
      $data = $this->pointService->updatePoint($userId, $type, $points, $pickupId);

      return $this->successResponse($data, 'Point updated successfully');
    } catch (\Exception $e) {
      return $this->errorResponse(
        'An error occurred while updating point',
        'POINT_SERVER_ERROR',
        [$e->getMessage()],
        StatusCode::INTERNAL_SERVER_ERROR
      );
    }
  }
}
