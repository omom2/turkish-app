<?php

namespace App\Service;

use App\AutoMapping;
use App\Entity\RealEstateEntity;
use App\Manager\RealEstateManager;
use App\Request\RealEstateCreateRequest;
use App\Response\GetAllRealEstateResponse;
use App\Response\GetRealEstateByIdResponse;
use App\Response\RealEstateCreateResponse;
use App\Response\RealEstateUpdateResponse;

class RealEstateService
{
    private $autoMapping;
    private $realEstateManager;

    public function __construct(AutoMapping $autoMapping, RealEstateManager $realEstateManager)
    {
        $this->autoMapping = $autoMapping;
        $this->realEstateManager = $realEstateManager;
    }

    public function realEstateCreate(RealEstateCreateRequest $request)
    {
        $create = $this->realEstateManager->RealEstateCreate($request);
        return $this->autoMapping->map(RealEstateEntity::class, RealEstateCreateResponse::class, $create);
    }

    public function getRealEstateById($request)
    {
        $result = $this->realEstateManager->getRealEstateById($request);

        $response = $this->autoMapping->map(RealEstateEntity::class, GetRealEstateByIdResponse::class, $result);

        return $response;
    }

    public function getAllRealEstate()
    {
        $response = [];
        $result = $this->realEstateManager->getAllRealEstate();
        foreach ($result as $row) {
            $response[] = $this->autoMapping->map(RealEstateEntity::class, GetAllRealEstateResponse::class, $row);
        }

        return $response;
    }

    public function getRealEstateByUser($userID)
    {
        $response = [];
        $result = $this->realEstateManager->getRealEstateByUser($userID);
        foreach ($result as $row) {
            $response[] = $this->autoMapping->map(RealEstateEntity::class, GetAllRealEstateResponse::class, $row);
        }

        return $response;
    }

    public function realEstateUpdate($request)
    {
        $result = $this->realEstateManager->realEstateUpdate($request);

        return $this->autoMapping->map(RealEstateEntity::class, RealEstateUpdateResponse::class, $result);
    }

    public function delete($request)
    {
        $result = $this->realEstateManager->delete($request);

        return $this->autoMapping->map(RealEstateEntity::class, GetRealEstateByIdResponse::class, $result);
    }
}