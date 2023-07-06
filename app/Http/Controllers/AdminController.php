<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $userCount = $this->getUserCount();
        return view('admin.dashboard', compact('userCount'));
    }

    public function getUserCount()
    {
        $userCount = Role::where('name', 'user')->first()->users()->count();

        return $userCount;
    }
}
