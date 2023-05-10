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
              <h5>Activity Type Table</h5>
            </div>
            <div class="row align-self-end">
              <div class="col-12 px-4">
                <button type="button" class="btn btn-primary" onclick="viewCreate();"><i class="fa fa-plus"></i> Create Activity Type</button>
              </div>
            </div>
            <div class="card-body px-0 pt-0">
              <div class="table-responsive p-3">
                <table class="table table-bordered" id="datatable" width="100%">
                  <thead class="text-center">
                    <tr>
                      <th>No</th>
                      <th>Name</th>
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
<div class="modal fade" id="modal-create-activity_type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-create-activity_type" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Create Activity Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-create-activity_type" action="javascript:void(0);">
          {{ csrf_field() }}
          <div id="data-create-activity_type" class="modal-body"></div>

          <div id="button-create-footer-activity_type" class="modal-footer"></div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-edit-activity_type" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-activity_type" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Edit Activity Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-activity_type" action="javascript:void(0);">
          {{ csrf_field() }}
          <div id="data-edit-activity_type" class="modal-body"></div>

          <div id="button-edit-footer-activity_type" class="modal-footer"></div>
      </form>
    </div>
  </div>
</div>
@endsection