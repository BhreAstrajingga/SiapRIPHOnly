@extends('layouts.admin')
@section('content')
@include('partials.subheader')
<div class="row">
	<div class="col-12">
		<div id="panel-1" class="panel panel-lock show" data-panel-sortable data-panel-close data-panel-collapsed>
			<form method="POST" action="{{ route("sroot.permissions.update", [$permission->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="panel-hdr">
                    <h2>
                        {{ trans('cruds.permission.title') }} | <span class="fw-300"><i>Edit</i></span>
                    </h2>
                    <div class="panel-toolbar">
                        <div class="form-group">
                            <button class="btn btn-success  waves-effect waves-themed btn-sm mr-2" type="submit">
                                {{ trans('global.save') }}
                            </button>
                            <a class="btn btn-danger  waves-effect waves-themed btn-sm mr-2" href="{{ route('sroot.permissions.index') }}">
                                {{ trans('global.cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="required" for="title">{{ __('Nama') }}</label>
                                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $permission->title) }}" required>
                                    @if($errors->has('title'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('title') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ __('Nama') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required">{{ __('Type') }}</label>
                                    <select class="form-control {{ $errors->has('perm_type') ? 'is-invalid' : '' }}" name="perm_type" id="perm_type" required>
                                        <option value disabled {{ old('perm_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach(App\Models\Permission::PERM_TYPE_SELECT as $key => $label)
                                            <option value="{{ $key }}" {{ old('perm_type', $permission->perm_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('perm_type'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('perm_type') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ __('Jenis hak akses') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="required">{{ __('Group') }}</label>
                                    <select class="form-control {{ $errors->has('grp_title') ? 'is-invalid' : '' }}" name="grp_title" id="grp_title" required>
                                        <option value disabled {{ old('grp_title', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        @foreach($grpTitle as $key => $label)
                                            @if ($label['is_hidden'] == '0')
                                                @if($label['level']=='0')
                                                    <option value="{{ $label['title'] }}" {{ old('grp_title', $permission->grp_title) === $label['title'] ? 'selected' : '' }} >{{ $label['title'] }}</option>
                                                @elseif ($label['level']=='1')
                                                    <option value="{{ $label['title'] }}" {{ old('grp_title', $permission->grp_title) === $label['title'] ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;{{ $label['title'] }}</option>
                                                @elseif ($label['level']=='2')
                                                    <option value="{{ $label['title'] }}" {{ old('grp_title', $permission->grp_title) === $label['title'] ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $label['title'] }}</option>
                                                @elseif ($label['level']=='3')
                                                    <option value="{{ $label['title'] }}" {{ old('grp_title', $permission->grp_title) === $label['title'] ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $label['title'] }}</option>
                                               @endif
                                            @endif
                                        @endforeach
                                    </select>
                                    @if($errors->has('grp_title'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('grp_title') }}
                                        </div>
                                    @endif
                                    <span class="help-block">{{ __('Group permission') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
