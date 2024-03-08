<?php

namespace App\Http\Controllers\Sroot;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Permission::query()->orderBy('created_at', 'desc')->select(sprintf('%s.*', (new Permission())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'permission_show';
                $editGate = 'permission_edit';
                $deleteGate = 'permission_delete';
                $crudRoutePart = 'permissions';

                return view('partials.rootDatatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });



            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('perm_type', function ($row) {
                return $row->perm_type ? Permission::PERM_TYPE_SELECT[$row->perm_type] : '';
            });
            $table->editColumn('grp_title', function ($row) {
                $grpTitle = trans('cruds');
                $out = '';
                foreach($grpTitle as $key => $label){
                    if ($label['title'] == $row->grp_title){
                        $out = $label['title'];
                        break;
                    }
                }

                return $row->grp_title ? $out : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        $breadcrumb = trans('cruds.permission.title') ." ". trans('global.list');
        return view('Superadmin.permissions.index', compact('breadcrumb'));
    }

    public function create()
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $grpTitle = trans('cruds');

        $breadcrumb = trans('global.create') . " ".  trans('cruds.permission.title') ;
        return view('Superadmin.permissions.create', compact( 'grpTitle', 'breadcrumb'));
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        return redirect()->route('sroot.permissions.index');
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grpTitle = trans('cruds');

        $breadcrumb = trans('global.edit') . " ".  trans('cruds.permission.title') ;
        return view('Superadmin.permissions.edit', compact('permission', 'grpTitle', 'breadcrumb'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        return redirect()->route('sroot.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $grpTitle = trans('cruds');
        $breadcrumb = trans('global.show') . " ".  trans('cruds.permission.title') ;
        return view('Superadmin.permissions.show', compact('permission', 'grpTitle', 'breadcrumb'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
