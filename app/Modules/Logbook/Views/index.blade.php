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
              <h5>List Activity Table</h5>
            </div>

            <div class="px-3" id="notification"></div>

            <div class="row align-self-end">
              <div class="col-12 px-4">
                {{-- <button type="button" class="btn btn-primary" onclick="viewCreate();"><i class="fa fa-plus"></i> Create List Activity</button> --}}
                <button type="button" class="btn btn-primary" onclick="location.href = `{{ url('logbook/create') }}` "><i class="fa fa-plus"></i> Create List Activity</button>
              </div>
            </div>
            
            <div class="card-body px-0 pt-0">
              <div class="p-3">
                <table class="table table-bordered table-display" id="datatable" width="100%">
                  <thead class="text-center">
                    <tr>
                      <th>No</th>
                      <th>Support Department</th>
                      <th>Activity Name</th>
                      <th>Activity Type</th>
                      <th>Detail Activity</th>
                      {{-- <th>Remarks</th> --}}
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Requestor</th>
                      {{-- <th>Channel Requestor</th> --}}
                      {{-- <th>Executor</th> --}}
                      {{-- <th>URL</th> --}}
                      {{-- <th>Additional Info</th> --}}
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
{{-- <div class="modal fade" id="modal-create-list-activity" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal-create-list-activity" aria-hidden="true">
  <div class="modal-dialog modal-lg scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Create List Activity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
          <div id="data-create-list-activity" class="modal-body"></div>

          <div id="button-create-footer-list-activity" class="modal-footer"></div>
    </div>
  </div>
</div> --}}

{{-- <div class="modal fade" id="modal-edit-list-activity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-list-activity" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Edit List Activity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-edit-list-activity" action="javascript:void(0);">
          {{ csrf_field() }}
          <div id="data-edit-list-activity" class="modal-body"></div>

          <div id="button-edit-footer-activity" class="modal-footer"></div>
      </form>
    </div>
  </div>
</div> --}}

<div class="modal fade" id="modal-detail-list-activity" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-list-activity" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">Detail List Activity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div id="data-detail-list-activity" class="modal-body"></div>
    </div>
  </div>
</div>
@endsection