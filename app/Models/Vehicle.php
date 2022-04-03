<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Mtownsend\XmlToArray\XmlToArray;
use Symfony\Component\Console\Helper\ProgressBar;


class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function equipments(): BelongsToMany
    {
        return $this->belongsToMany(VehicleEquipment::class, 'equipment_vehicles', 'vehicle_id', 'equipment_id');
    }

    /**
     * Создание транспортных средств на основе xml выгрузки
     *
     * @param string $xmlString
     * @param ProgressBar|null $progressBar
     * @return array
     */
    public static function createFromXml(string $xmlString, ProgressBar $progressBar = null): array
    {
        /*
         * С помощью библиотеки XmlToArray конверчу xml в массив
         * В отличии от json_decode(json_encode(simplexml_load_string($xmlString)),TRUE);
         * Данная библиотека конвертирует атрибуты
         * */
        $vehicles = XmlToArray::convert($xmlString)['vehicle'];

        if (isset($progressBar)) {
            $progressBar->start(count($vehicles));
        }

        $oldVehicles = self::all();
        $dealers = VehicleDealer::all();
        $categories = VehicleCategory::all();
        $subcategories = VehicleSubcategory::all();
        $vehicleModels = VehicleModel::all();
        $brands = VehicleBrand::all();
        $generations = VehicleGeneration::all();
        $bodyConfigurations = VehicleBodyConfiguration::all();
        $modifications = VehicleModification::all();
        $complectations = VehicleComplectation::all();
        $equipmentGroups = VehicleEquipmentGroup::all();
        $equipments = VehicleEquipment::all();
        $countries = Country::all();

        /**
         * Получение id связанной таблицы из коллекции, в случае отсутствия создание нового экземпляра
         *
         * @param Collection $collection    Коллекция со строками в базе данных
         * @param array $externalData       Массив с внешними данными (externalId и name)
         * @param string $model             Наименование модели
         * @return null
         */
        function getIdByExternalData(Collection $collection, array $externalData, string $model)
        {
            if (empty($externalData) && $externalData != 0) return null;
            $collectionItem = $collection->firstWhere('externalId', intval($externalData['@attributes']['id']));
            if (!isset($collectionItem)) {
                $collectionItem = $model::create([
                    'externalId' => intval($externalData['@attributes']['id']),
                    'name' => $externalData['@content']
                ]);
                $collection->push($collectionItem);
            }
            return $collectionItem->id;
        }

        /**
         * Проверка строки на наличие
         *
         * @param $data
         * @return mixed|null
         */
        function getNotEmptyData($data)
        {
            if (empty($data) && $data != 0) return null;
            return $data;
        }

        $addVehicleCount = 0;
        $updateVehicleCount = 0;

        foreach ($vehicles as $externalVehicle) {
            $externalId = intval($externalVehicle['id']);
            $vehicle = Vehicle::updateOrCreate(['externalId' => $externalId], [
                'uin' => getNotEmptyData($externalVehicle['uin']),
                'dealer_id' => getIdByExternalData($dealers, $externalVehicle['dealer'],
                    VehicleDealer::class),
                'category_id' => getIdByExternalData($categories, $externalVehicle['category'],
                    VehicleCategory::class),
                'subcategory_id' => getIdByExternalData($subcategories, $externalVehicle['subcategory'],
                    VehicleSubcategory::class),
                'brand_id' => getIdByExternalData($brands, $externalVehicle['brand'],
                    VehicleBrand::class),
                'model_id' => getIdByExternalData($vehicleModels, $externalVehicle['model'],
                    VehicleModel::class),
                'generation_id' => getIdByExternalData($generations, $externalVehicle['generation'],
                    VehicleGeneration::class),
                'bodyConfiguration_id' => getIdByExternalData($bodyConfigurations, $externalVehicle['bodyConfiguration'],
                    VehicleBodyConfiguration::class),
                'modification_id' => getIdByExternalData($modifications, $externalVehicle['modification'],
                    VehicleModification::class),
                'complectation_id' => getIdByExternalData($complectations, $externalVehicle['complectation'],
                    VehicleComplectation::class),
                'country_id' => getIdByExternalData($countries, $externalVehicle['country'],
                    Country::class),
                'type' => getNotEmptyData($externalVehicle['type']),
                'year' => getNotEmptyData($externalVehicle['year']),
                'brandComplectationCode' => getNotEmptyData($externalVehicle['brandComplectationCode']),
                'engineType' => getNotEmptyData($externalVehicle['engineType']),
                'engineVolume' => getNotEmptyData($externalVehicle['engineVolume']),
                'enginePower' => getNotEmptyData($externalVehicle['enginePower']),
                'bodyType' => getNotEmptyData($externalVehicle['bodyType']),
                'bodyDoorCount' => getNotEmptyData($externalVehicle['bodyDoorCount']),
                'bodyColor' => getNotEmptyData($externalVehicle['bodyColor']),
                'bodyColorMetallic' => getNotEmptyData($externalVehicle['bodyColorMetallic']),
                'driveType' => getNotEmptyData($externalVehicle['driveType']),
                'gearboxType' => getNotEmptyData($externalVehicle['gearboxType']),
                'gearboxGearCount' => getNotEmptyData($externalVehicle['gearboxGearCount']),
                'steeringWheel' => getNotEmptyData($externalVehicle['steeringWheel']),
                'mileage' => getNotEmptyData($externalVehicle['mileage']),
                'mileageUnit' => getNotEmptyData($externalVehicle['mileageUnit']),
                'price' => getNotEmptyData($externalVehicle['price']),
                'specialOffer' => getNotEmptyData($externalVehicle['specialOffer']),
                'specialOfferPreviousPrice' => getNotEmptyData($externalVehicle['specialOfferPreviousPrice']),
                'tradeinDiscount' => getNotEmptyData($externalVehicle['tradeinDiscount']),
                'creditDiscount' => getNotEmptyData($externalVehicle['creditDiscount']),
                'insuranceDiscount' => getNotEmptyData($externalVehicle['insuranceDiscount']),
                'maxDiscount' => getNotEmptyData($externalVehicle['maxDiscount']),
                'availability' => getNotEmptyData($externalVehicle['availability']),
                'ptsType' => getNotEmptyData($externalVehicle['ptsType']),
                'operatingTime' => getNotEmptyData($externalVehicle['operatingTime']),
                'ecoClass' => getNotEmptyData($externalVehicle['ecoClass']),
                'driveWheel' => getNotEmptyData($externalVehicle['driveWheel']),
                'axisCount' => getNotEmptyData($externalVehicle['axisCount']),
                'brakeType' => getNotEmptyData($externalVehicle['brakeType']),
                'cabinType' => getNotEmptyData($externalVehicle['cabinType']),
                'maximumPermittedMass' => getNotEmptyData($externalVehicle['maximumPermittedMass']),
                'saddleHeight' => getNotEmptyData($externalVehicle['saddleHeight']),
                'cabinSuspension' => getNotEmptyData($externalVehicle['cabinSuspension']),
                'chassisSuspension' => getNotEmptyData($externalVehicle['chassisSuspension']),
                'length' => getNotEmptyData($externalVehicle['length']),
                'width' => getNotEmptyData($externalVehicle['width']),
                'bodyVolume' => getNotEmptyData($externalVehicle['bodyVolume']),
                'bucketVolume' => getNotEmptyData($externalVehicle['bucketVolume']),
                'tractionClass' => getNotEmptyData($externalVehicle['tractionClass']),
                'refrigeratorClass' => getNotEmptyData($externalVehicle['refrigeratorClass']),
                'craneArrowRadius' => getNotEmptyData($externalVehicle['craneArrowRadius']),
                'craneArrowLength' => getNotEmptyData($externalVehicle['craneArrowLength']),
                'craneArrowPayload' => getNotEmptyData($externalVehicle['craneArrowPayload']),
                'loadHeight' => getNotEmptyData($externalVehicle['loadHeight']),
                'photoCount' => getNotEmptyData($externalVehicle['photoCount']),
                'description' => getNotEmptyData($externalVehicle['description']),
                'ownersCount' => getNotEmptyData($externalVehicle['ownersCount']),
                'vehicleCondition' => getNotEmptyData($externalVehicle['vehicleCondition']),
                'brandColorCode' => getNotEmptyData($externalVehicle['brandColorCode']),
                'brandInteriorCode' => getNotEmptyData($externalVehicle['brandInteriorCode']),
                'certificationProgram' => getNotEmptyData($externalVehicle['certificationProgram']),
                'acquisitionSource' => getNotEmptyData($externalVehicle['acquisitionSource']),
                'acquisitionDate' => getNotEmptyData($externalVehicle['acquisitionDate']), //Data
                'manufactureDate' => getNotEmptyData($externalVehicle['manufactureDate']), //Data
            ]);

            $vehicleKey = $oldVehicles->search($vehicle);
            if ($vehicleKey !== false) {
                $updateVehicleCount++;
                $oldVehicles->pull($vehicleKey);
            } else {
                $addVehicleCount++;
            }
            $equipmentIds = [];

            if (!empty($externalVehicle['equipment'])) {
                if (isset($externalVehicle['equipment']['group']['@attributes'])) {
                    $externalEquipmentGroups = [$externalVehicle['equipment']['group']];
                } else {
                    $externalEquipmentGroups = $externalVehicle['equipment']['group'];
                }
                foreach ($externalEquipmentGroups as $externalEquipmentGroup) {
                    $equipmentGroup = $equipmentGroups->firstWhere('externalId', $externalEquipmentGroup['@attributes']['id']);
                    if (!isset($equipmentGroup)) {
                        $equipmentGroup = VehicleEquipmentGroup::create([
                            'externalId' => $externalEquipmentGroup['@attributes']['id'],
                            'name' => $externalEquipmentGroup['@attributes']['name']
                        ]);
                        $equipmentGroups->push($equipmentGroup);
                    }
                    if (isset($externalEquipmentGroup['element']['@attributes'])) {
                        $externalEquipments = [$externalEquipmentGroup['element']];
                    } else {
                        $externalEquipments = $externalEquipmentGroup['element'];
                    }
                    foreach ($externalEquipments as $externalEquipment) {
                        $equipment = $equipments->firstWhere('externalId', intval($externalEquipment['@attributes']['id']));
                        if (!isset($equipment)) {
                            $equipment = VehicleEquipment::create([
                                'externalId' => intval($externalEquipment['@attributes']['id']),
                                'group_id' => $equipmentGroup->id,
                                'name' => $externalEquipment['@content']
                            ]);
                            $equipments->push($equipment);
                        }
                        $equipmentIds[] = $equipment->id;
                    }
                }
            }
            $vehicle->equipments()->sync($equipmentIds);
            if (isset($progressBar)) {
                $progressBar->advance();
            }
        }

        // Удаляем отсутствующие в файле транспортные средства
        foreach ($oldVehicles as $deleteVehicle) {
            $deleteVehicle->delete();
        }

        if (isset($progressBar)) {
            $progressBar->finish();
        }

        return [
            'parseCount' => count($vehicles),
            'addCount' => $addVehicleCount,
            'updateCount' => $updateVehicleCount,
            'deleteCount' => $oldVehicles->count()
        ];
    }
}

