<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentType;
use DomainException;

final class EquipmentService
{
    const REGEX_RULES = [
        'N' => '[0-9]{1,1}',
        'A' => '[A-Z]{1,1}',
        'a' => '[a-z]{1,1}',
        'X' => '[0-9A-Z]{1,1}',
        'Z' => '[-_@]{1,1}',
    ];


    /**
     * Одиночное или множественное создание оборудование
     * @param array $equipments
     * @return bool|array
     */
    public function multipleCreate(array $equipments): bool|array
    {
        // Переменная предназначенная для хранение ошибок. Если какое-то оборудование не прошло проверку, то мы
        // заполним этот массив
        $errors = [];

        // Разделил на две циклы, чтобы не было такого, что из 10 оборудований, добавлено 5, а на 6-том ошибке
        // И вернув пользователю ошибку об этом, что на 6-том оборудований ошибка, он сможет скорректировать данные и отправить снова
        // и у него будет ошибок со словами "такой серийный номер в базе существует"
        // Так как мы не добавили первые 5, когда у нас регулярка проходила.
        foreach ($equipments as $equipment) {

            $checkResult = $this->checkSerialNumber(
                serialNumber: $equipment['serial_number'],
                equipmentTypeId: $equipment['equipment_type_id']
            );

            // Если у нас false, значит данное оборудование проверку не прошло
            if (!$checkResult) {
                $errors[] = $equipment['serial_number'];
                continue;
            }

            Equipment::query()
                ->create([
                    'equipment_type_id' => $equipment['equipment_type_id'],
                    'serial_number' => $equipment['serial_number'],
                    'comment' => $equipment['comment'],
                ]);
        }

        return !empty($errors) ? $errors : true;
    }

    /**
     * Проверка серийного номера на соответствие шаблона
     * Проверка с помощью регулярных выражений
     * @param string $serialNumber
     * @param int $equipmentTypeId
     * @return bool
     */
    protected function checkSerialNumber(string $serialNumber, int $equipmentTypeId): bool
    {
        // Получение шаблона серийного номера
        $regex = EquipmentType::query()->find($equipmentTypeId)->mask;

        // Генерация регулярного выражения на основе шаблона
        $generatedRegex = $this->generateRegex($regex);

        // Наш не совпадает
        return (bool)preg_match($generatedRegex, $serialNumber);
    }


    /**
     * Редактирование оборудования
     * @param int $id
     * @param int $typeId
     * @param string|int $serialNumber
     * @param string|null $comment
     * @return bool
     */
    public function edit(int $id, int $typeId, string|int $serialNumber, ?string $comment = null): bool
    {
        $regex = EquipmentType::query()->find($typeId)->mask;

        // Генерация регулярного выражения на основе шаблона
        $generatedRegex = $this->generateRegex($regex);

        // Если не совпадает по шаблону, то возвращаем ошибку
        if (!preg_match($generatedRegex, $serialNumber)) {
            return false;
        }

        Equipment::query()
            ->find($id)
            ->update([
                'equipment_type_id' => $typeId,
                'serial_number' => $serialNumber,
                'comment' => $comment,
            ]);

        return true;
    }

    /**
     * Генерацие регулярного приложения на основе константы
     * @param string $template
     * @return string
     */
    protected function generateRegex(string $template): string
    {
        $result = '';
        $array = str_split($template);

        foreach ($array as $word) {
            if (!array_key_exists($word, self::REGEX_RULES)) throw new DomainException();

            $result .= self::REGEX_RULES[$word];
        }

        return '#^' . $result . '$#m';
    }
}
