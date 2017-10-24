<?php

namespace App\Repositories\Backend\Access\Permission;

use App\Repositories\BaseRepository;
use App\Models\Access\Permission\Permission;
use Yajra\Datatables\Datatables;

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Permission::class;


    public function create($data){

        return  Permission::create([
            'name'=>$data['name'],
            'display_name'=>$data['display_name']
        ]);
    }

    public function update($id,$data){

        Permission::whereId($id)->update($data);

    }


    public function getPermissionTable(){

        return Datatables::of(Permission::all())
            ->escapeColumns(['name', 'display_name'])
            ->addColumn('actions', function($permission) {
                return $permission->action_buttons;
            })
            ->make(true);

    }

    public function getPermissionById($id){
        return Permission::whereId($id)->first();
    }

    public function delete($id){
        Permission::whereId($id)->delete();
    }

    public function getAll(){
        return Permission::all();
    }
}
