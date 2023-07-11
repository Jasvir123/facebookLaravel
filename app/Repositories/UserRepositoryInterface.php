<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getAll(Request $request);

    public function find($id);

    public function create($data);

    public function update($id, $data);

    public function delete($id);
}
