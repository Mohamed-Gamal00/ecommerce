<?php

namespace App\Repositories\Admin;

interface AdminInterface
{
    public function getAll();

    public function store($params);

    public function update($params, $id);

    public function delete($id);

    public function changePassword($id, $params);
}
