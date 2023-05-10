@section('title')
{{ $title }}
@endsection

@extends('layouts.template')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-4 text-center">
              <h5>List User Table</h5>
            </div>

            <div class="px-3" id="notification"></div>

            <div class="row align-self-end">
              <div class="col-12 px-4">
                <button type="button" class="btn btn-primary" onclick="viewCreate();"><i class="fa fa-plus"></i> Create User</button>
              </div>
            </div>
            <div class="card-body px-0 pt-0">
              <div class="table-responsive p-3">
                <table class="table table-bordered table-display" id="datatable" width="100%">
                  <thead class="text-center">
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table> 
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-create-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-create-user" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Create User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-create-user" action="javascript:void(0);">
        {{ csrf_field() }}
        <div id="data-create-user" class="modal-body"></div>
        
        <div id="button-create-footer-user" class="modal-footer"></div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-edit-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-user" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-user" action="javascript:void(0);">
          {{ csrf_field() }}
          <div id="data-edit-user" class="modal-body"></div>

          <div id="button-edit-footer-user" class="modal-footer"></div>
      </form>
    </div>
  </div>
</div>
@endsection