<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use App\Repositories\Admin\AdminInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminInterface
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function getAll()
    {
        return $this->admin->latest()
            ->where('id', '!=', auth()->guard('admin')->user()->id)
            ->where('id', '!=', 2)
            ->paginate();
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $admin = $this->admin->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['new_password'])
            ]);

            $admin->rules()->attach($data['rules']);

            return $admin;
        });
    }

    public function delete($id)
    {
        $admin = $this->admin->findOrFail($id);
        return $admin->delete();
    }

    public function changePassword($id, $data)
    {
        $admin = $this->admin->findOrFail($id);
        return $admin->update(['password' => Hash::make($data['new_password'])]);
    }

    public function update($data, $id)
    {

        return DB::transaction(function () use ($data, $id) {
            $admin = $this->admin->findOrFail($id);

            $admin->update($data);

            $admin->rules()->sync($data['rules']);

            return $admin;
        });
    }

}
