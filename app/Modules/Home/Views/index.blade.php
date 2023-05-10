@section('title')
{{ $title }}
@endsection

@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="card card-body blur shadow-blur overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto">
                <div class="avatar avatar-xl position-relative">
                    @if($profile->img_path !== null)
                    <img src="{{ asset($profile->img_path) }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    @else
                    <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    @endif
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100">
                    <h5 class="mb-1">
                    {{ $profile->name }}
                    </h5>
                    <p class="mb-0 font-weight-bold text-sm">
                    {{ $profile->job }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@if(\Auth::user()->role_id === 1)
<div class="container-fluid py-4">
  <div class="row">
      <div class="col-12">
        <div class="card mb-5">
          <div class="card-body px-0 pt-0">
            <div class="table-responsive p-3">
              <table class="table table-bordered table-display" id="datatable" width="100%">
                <thead class="text-center">
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Last Login</th>
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
@else
<div class="container-fluid py-4">
  <div class="row">
      <div class="col-12">
        <div class="card mb-5">
          <div class="card-body p-3">
            <div id='calendar'></div>
          </div>
        </div>
      </div>
  </div>
</div>
@endif
@endsection