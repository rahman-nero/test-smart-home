<?php

namespace App\Http\Controllers\Api\Equipment;

use App\Http\Requests\Api\Equipment\CreateRequest;
use App\Http\Requests\Api\Equipment\EditRequest;
use App\Http\Resources\Api\Equipment\EquipmentPaginateResource;
use App\Http\Resources\Api\Equipment\EquipmentResource;
use App\Http\Resources\Api\Equipment\EquipmentShowResource;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class EquipmentController
{
    private EquipmentService $service;

    /**
     * @param EquipmentService $service
     */
    public function __construct(EquipmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Getting equipments along with the opportunity to search
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
     * Показ определенного оборудования
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $equipment = Equipment::query()->with('type')->find($id);

        if (!$equipment) {
            return new JsonResponse(['code' => 404], 404);
        }

        return new JsonResponse(['code' => 200, 'message' => new EquipmentShowResource($equipment)]);
    }

    /**
     * Создание одного или множество оборудований
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $equipments = $request->input('equipments');

        $result = $this->service->multipleCreate($equipments);

        if (is_array($result)) {
            return new JsonResponse([
                'code' => 422,
                'message' =>  'Оборудования не проходит валидацию, пожалуйста, проверьте правильность серийного номера',
                'errors' => $result,
            ], 422);
        }

        return new JsonResponse(['code' => 204], 204);
    }

    /**
     * Редактирование определенного оборудования
     * @param EditRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function edit(EditRequest $request, int $id)
    {
        $typeId = $request->input('type_id');
        $serialNumber = $request->input('serial_number');
        $comment = $request->input('comment');

        $result = $this->service->edit(id: $id, typeId: $typeId, serialNumber: $serialNumber, comment: $comment);

        if (!$result) {
            return new JsonResponse([
                'code' => 422,
                'message' => 'Оборудования ' . $serialNumber . ' не проходит валидацию, пожалуйста, проверьте правильность серийного номера'
            ], 422);
        }

        return new JsonResponse(['code' => 200]);
    }


    /**
     * Мягкое удаление оборудования
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        $result = Equipment::query()->find($id)->delete();

        if (!$result) {
            return new JsonResponse(['code' => 503, 'message' => 'Не удалось удалить оборудование'], 503);
        }

        return new JsonResponse(['code' => 200, 'message' => 'Оборудование успешно удалено']);
    }


    /**
     * @param string $query
     * @return JsonResponse
     */
    protected function queryResult(string $query)
    {
        $result = Equipment::query()
            ->select(['id', 'serial_number', 'equipment_type_id'])
            ->where('serial_number', 'like', "%$query%")
            ->with('type')
            ->get();

        return new JsonResponse(['code' => 200, 'message' => new EquipmentResource($result)]);
    }


    /**
     * @param int $limit
     * @return JsonResponse
     */
    protected function paginateResult(int $limit)
    {
        $result = Equipment::query()
            ->with('type')
            ->paginate($limit);

        return new JsonResponse(['code' => 200, 'message' => new EquipmentPaginateResource($result)]);
    }
}
