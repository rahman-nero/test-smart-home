<?php

namespace App\Http\Controllers\Api\Equipment;

use App\Http\Resources\EquipmentPaginateResource;
use App\Http\Resources\EquipmentTypePaginateResource;
use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class EquipmentTypeController
{
    /**
     * Вывод всех типов оборудования либо поиск по ним
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $limit = $request->input('limit', 10);

        if ($query) {
            return $this->queryResult($query);
        }

        return $this->paginateResult($limit);
    }

    /**
     * @param string $query
     * @return JsonResponse
     */
    protected function queryResult(string $query)
    {
        $result = EquipmentType::query()
            ->where('title', 'like', "%$query%")
            ->get();

        return new JsonResponse(['code' => 200, 'message' => new EquipmentTypeResource($result)]);
    }

    /**
     * @param int $limit
     * @return JsonResponse
     */
    protected function paginateResult(int $limit)
    {
        $result = EquipmentType::query()
            ->paginate($limit);

        return new JsonResponse(['code' => 200, 'message' => new EquipmentPaginateResource($result)]);
    }
}
