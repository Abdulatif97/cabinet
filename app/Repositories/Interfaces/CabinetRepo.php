<?php

namespace App\Repositories\Interfaces;

interface CabinetRepo
{
    public function getAllCabinets();

    public function getCabinetById($id);

    public function createOrUpdate( $id = null, $collection = [] );

    public function setSchedule($data);

    public function deleteCabinet($id);
}
