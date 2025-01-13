<?php

namespace App\Repositories\Banner;

use App\Models\Design;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

interface HeaderBannerInterface
{
    public function getMainDesign();

    public function store($params);

    public function getById($id);

    public function update($params, $id);

    public function delete($id);
}
