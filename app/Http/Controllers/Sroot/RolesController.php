<?php

namespace App\Http\Controllers\Sroot;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Role::with(['permissions'])->select(sprintf('%s.*', (new Role())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'role_show';
                $editGate = 'role_edit';
                $deleteGate = 'role_delete';
                $crudRoutePart = 'roles';

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
            $table->editColumn('permissions', function ($row) {
                $labels = [];
                foreach ($row->permissions as $permission) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $permission->title);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'permissions']);

            return $table->make(true);
        }
        $grpTitle = trans('cruds');

        $breadcrumb = trans('cruds.role.title') ." ". trans('global.list');
        return view('Superadmin.roles.index', compact('grpTitle', 'breadcrumb'));
    }

    public function create()
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$module_name = 'FOREIGN API';
		$page_title = 'Google Map API';
		$page_heading = 'Google Map API ';
		$heading_class = 'fal fa-google';

        $permissions = Permission::pluck('title','id' );
        $permi = Permission::all();
        $grpTitle = trans('cruds');

        $breadcrumb = trans('global.create') . " ".  trans('cruds.role.title') ;
        return view('Superadmin.roles.create', compact('permissions',  'grpTitle', 'permi', 'breadcrumb'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->input('permissions', []));

        session()->flash('message', trans('global.create_success'));
        return redirect()->route('sroot.roles.index');
    }

    public function edit(Role $role)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::pluck('title','id' );
        $permi = Permission::all();
        $role->load('permissions');
        $grpTitle = trans('cruds');
        $mnfound = false;
        $breadcrumb = trans('global.edit') . " ".  trans('cruds.role.title') ;
        return view('Superadmin.roles.edit', compact('permissions', 'role', 'grpTitle', 'permi', 'mnfound', 'breadcrumb'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        //dd($request->all());
        $role->update($request->all());
        $role->permissions()->sync($request->input('permissions', []));
        session()->flash('message', trans('global.update_success'));

        return redirect()->route('sroot.roles.index');
    }

    public function show(Role $role)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->load('permissions');
        $breadcrumb = trans('global.show') . " ".  trans('cruds.role.title') ;
        return view('Superadmin.roles.show', compact('role', 'breadcrumb'));
    }

    public function destroy(Role $role)
    {
        abort_if(Gate::denies('can_sroot'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        Role::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
