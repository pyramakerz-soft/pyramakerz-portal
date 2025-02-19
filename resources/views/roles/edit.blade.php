@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <br/>
                <label>
                    <input type="checkbox" id="select-all">
                    <strong>Select All</strong>
                </label>
                <br/>
                @foreach($permission as $value)
                    <label>
                        <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" 
                            class="permission-checkbox" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                        {{ $value->name }}
                    </label>
                    <br/>
                @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-sm mb-3"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </div>
    </div>
</form>

<p class="text-center text-primary"><small>Tutorial by ItSolutionStuff.com</small></p>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let selectAll = document.getElementById("select-all");
    let checkboxes = document.querySelectorAll(".permission-checkbox");

    function updateSelectAll() {
        selectAll.checked = Array.from(checkboxes).every(cb => cb.checked);
    }

    // Run on page load to check if all checkboxes are selected
    updateSelectAll();

    selectAll.addEventListener("change", function () {
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateSelectAll);
    });
});
</script>
@endsection
