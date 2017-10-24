<?php

namespace App\Http\Controllers\Backend\Access\Permission;

use App\Http\Requests\Backend\Access\Permission\StorePermissionRequest;
use App\Models\Access\Permission\Permission;
use App\Models\Access\Role\Role;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Access\Role\RoleRepository;
use App\Http\Requests\Backend\Access\Role\StoreRoleRequest;
use App\Http\Requests\Backend\Access\Role\ManageRoleRequest;
use App\Http\Requests\Backend\Access\Role\UpdateRoleRequest;
use App\Repositories\Backend\Access\Permission\PermissionRepository;
use Illuminate\Http\Request;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Backend\Access\Permission
 */
class PermissionController extends Controller
{
    /**
     * @var RoleRepository
     */
    protected $roles;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * PermissionController constructor.
     * @param RoleRepository $roles
     * @param PermissionRepository $permissions
     */
    public function __construct(PermissionRepository $permissions)
	{
        $this->permissions = $permissions;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(Request $request)
	{
        return view('backend.access.permission.index');
    }

    /**
     * @param StoreRoleRequest $request
     * @return mixed
     */
    public function create(Request $request)
    {
        return view('backend.access.permission.create');
    }


    /**
     * @param  StoreRoleRequest $request
     * @return mixed
     */
    public function store(StorePermissionRequest $request)
    {
        $this->permissions->create($request->all());
        return redirect()->route('admin.access.permission.index')->withFlashSuccess('Permission Create Success');
    }

    /**
     * @param  Role $role
     * @param  ManageRoleRequest $request
     * @return mixed
     */
    public function edit($id)
    {
        $permission = $this->permissions->getPermissionById($id);
        return view('backend.access.permission.edit',['permission'=>$permission]);
    }

    /**
     * @param  Role $role
     * @param  UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Permission $permission, StorePermissionRequest $request)
    {
        $this->permissions->update($permission->id, $request->except(['_method','_token']));
        return redirect()->route('admin.access.permission.index')->withFlashSuccess('Permission Update Success');
    }

    /**
     * @param  Role $role
     * @param  ManageRoleRequest $request
     * @return mixed
     */
    public function destroy($id)
    {
        $this->permissions->delete($id);
        return redirect()->route('admin.access.permission.index')->withFlashSuccess('Permission Delete Success');
    }

    public function table(){

       return $this->permissions->getPermissionTable();

    }

}