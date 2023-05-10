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
              <h5>Create Form</h5>
          </div>
            
            <div class="card-body px-0 pt-0">
              <div class="p-3">
                @include('Logbook::fields')
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-create-list-activity" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal-create-list-activity" aria-hidden="true">
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
</div>

<div class="modal fade" id="modal-edit-list-activity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-list-activity" aria-hidden="true">
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
</div>

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