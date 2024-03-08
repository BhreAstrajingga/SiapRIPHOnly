@extends('layouts.admin')
@section('content')
@include('partials.subheader')
<div class="row">
	<div class="col-12">
		<div id="panel-1" class="panel panel-lock show" data-panel-sortable data-panel-close data-panel-collapsed>
			<div class="panel-hdr">
				<h2>
					{{ trans('cruds.permission.title') }} | <span class="fw-300"><i>Detail</i></span>
				</h2>
				<div class="panel-toolbar">
					<a class="btn btn-primary  waves-effect waves-themed btn-sm mr-2" href="{{ route('sroot.permissions.index') }}">
						{{ trans('global.back_to_list') }}
					</a>
				</div>
			</div>
			<div class="panel-container show">
				<div class="panel-content">
					<div class="row">
						<div class="col-12">

                            <table class="table table-bordered table-striped">
                                <tbody >
                                    <tr>
                                        <th>
                                            {{ __('Nama') }}
                                        </th>
                                        <td>
                                            {{ $permission->title }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ __('Type')}}
                                        </th>
                                        <td>
                                            {{ App\Models\Permission::PERM_TYPE_SELECT[$permission->perm_type] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ __('Group') }}
                                        </th>
                                        <td>
                                            {{ $permission->grp_title }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
