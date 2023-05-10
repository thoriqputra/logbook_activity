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
            <h5>Edit Profile</h5>
          </div>

          <div class="row">
            <div class="card-body">
              <div class="d-flex justify-content-center">
                <form action="{{ route('update-profile') }}" method="post" class="col-6" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <div class="form-group">
                    <label for="upload_image">Unggah Gambar</label>
                    <input name="profile[upload_image]" type="file" class="form-control dropify" id="upload_image" accept="image/*" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg" data-default-file="{{ asset($profile->img_path) }}">
                  </div>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input name="profile[name]" type="text" class="form-control" id="name" placeholder="Name" value="{{ $profile->name }}">
                  </div>
                  <div class="form-group">
                    <label for="job">Job</label>
                    <input name="profile[job]" type="text" class="form-control" id="job" placeholder="Job" value="{{ $profile->job }}">
                  </div>
                  <div class="form-group text-center mt-5">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection