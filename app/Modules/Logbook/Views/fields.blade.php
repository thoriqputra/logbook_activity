<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="input_type">Input Type <span class="required">*</span></label>
            <select type="text" name="input_type" class="form-control" id="input_type"">
                <option>--- Select Input Type ---</option>
                <option value="form">Form</option>
                <option value="upload-file">Upload File</option>
            </select>
        </div>
    </div>
</div>
<div class="row" id="show-form">
    <div class="col-md-12">
        <form id="page-form-service">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="start_date">Start Date <span class="required">*</span></label>
                        <input type="text" class="form-control" name="start_date" required data-alt-format="d-m-Y H:i">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="end_date">End Date <span class="required">*</span></label>
                        <input type="text" class="form-control" name="end_date" required data-alt-format="d-m-Y H:i">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="duration">Duration <span class="required">*</span></label>
                        <input type="text" class="form-control" name="duration" required id="duration" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="support_department_name">Support Department Name <span class="required">*</span></label>
                <select name="support_department_name" class="form-select" id="support_department_name" data-placeholder="Select Support Department Name">
                    <option>Pilih Support Department</option>
                    @foreach($support_department as $key => $rows)
                    <option value="{{ $rows->id }}">{{ $key+1 .". ". $rows->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="show-activity"></div>
            <div class="form-group">
                <label for="activity_type">Activity Type <span class="required">*</span></label>
                <select name="activity_type" class="form-select" id="activity_type" data-placeholder="Select Activity Type">
                    <option>Pilih Activity Type</option>
                    @foreach($activity_type as $key => $rows)
                    <option value="{{ $rows->id }}">{{ $key+1 .". ". $rows->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="detail_activity">Detail Activity <span class="required">*</span></label>
                <textarea name="detail_activity" class="form-control" id="detail_activity" placeholder="Detail Activity"></textarea>
            </div>
            <div class="form-group">
                <label for="notes">Remarks (Optional)</label>
                <textarea name="remarks" class="form-control" id="remarks" placeholder="Remarks"></textarea>
            </div>
            <div class="form-group">
                <label for="requestor">Requestor <span class="required">*</span></label>
                <select name="requestor[]" class="form-select" id="requestor" data-placeholder="Select Requestor" multiple>
                    <option>Pilih Requestor</option>
                    @foreach($requestor as $key => $rows)
                        <option value="{{ $rows->id }}">{{ $key+1 .". ". $rows->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="channel_requestor">Channel Requestor <span class="required">*</span></label>
                <select name="channel_requestor" class="form-select" id="channel_requestor" data-placeholder="Select Channel Requestor">
                    <option>Pilih Channel Requestor</option>
                    @foreach($channel_requestor as $key => $rows)
                        <option value="{{ $rows->id }}">{{ $key+1 .". ". $rows->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="executor">Executor <span class="required">*</span></label>
                <input type="text" name="executor" class="form-control" id="executor" placeholder="Executor" value="{{ Auth::user()->profile->name }}" readonly>
            </div>
            <div class="form-group">
                <label for="url">Link Document (sharepoint, gdocs, others)</label>
                <input type="text" name="url" class="form-control" id="url" placeholder="Url">
            </div>
        </form>
    </div>
</div>
<div class="row" id="show-upload-file">
    <div class="card-header pb-4 text-center">
        <h5>Form Upload Service</h5>
    </div>
    <nav class="pb-4">
        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
            <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">
            Step 1
            <br>
            <label class="text-white">Upload File</label>
            </a>
            <a class="nav-link disabled" id="step2-tab" data-bs-toggle="tab" href="#step2">
            Step 2 
            <br>
            <label class="text-white">Validation, Verification & Revisi Data</label>
            </a>
        </div>
    </nav>
    <div class="col-md-12">
        <div class="tab-content py-4">
            <div class="tab-pane fade show active" id="step1">
                <div class="alert alert-info" role="alert">
                    <h6>INFORMASI !</h6> 
                    <p>Pemberitahuan Service Request yang diupload harap sama dengan template yang di sediakan & data disesuaikan dengan headernya tanpa merubah posisi kolom.</p>
                    <button type="button" class="btn btn-success btn-sm" id="download-template">Download Template</button>
                </div>
                <div class="row">
                    <form id="page-form-upload-file" class="d-flex justify-content-center">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="upload_file">Upload File</label>
                                <div class="input-group">
                                    <input type="file" name="upload_file" class="form-control-sm dropify" id="upload_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-allowed-file-extensions="xlsx">
                                    {{-- <button type="button" class="btn btn-sm btn-secondary" id="remove-file">Remove</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="step2">
                <div class="table-responsive p-3">
                {{-- <div class="p-3"> --}}
                    <form id="page-verification-data">
                        <table class="table table-display table-bordered nowrap" id="table-list-activity" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Support Department Name</th>
                                    <th>Activity Name</th>
                                    <th>Activity Type</th>
                                    <th>Detail Activity</th>
                                    <th>Remarks</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    {{-- <th>Duration</th> --}}
                                    <th>Requestor</th>
                                    <th>Channel Requestor</th>
                                    {{-- <th>Executor</th> --}}
                                    <th>Url</th>
                                    {{-- <th>Additional Info</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer id="button-create-footer-list-activity"></footer>