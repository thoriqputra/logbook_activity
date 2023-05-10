<!-- LOGIN -->
@if(Request::is('/') || Request::segment(1) == 'login')
<script type="text/javascript">
$(function() {
	let notification    = '{{ Session::get('notification') }}',
    	expired         = '{{ Session::get('expired') }}',
    	permission      = '{{ Session::get('permission') }}';

	if(notification === "SUCCESS"){
		Swal.fire({
			toast: true,
			position: 'top-end',
			type: 'success',
			title: 'Berhasil untuk Log out',
			showConfirmButton: false,
			timer: 2.5 * 1000,
			width: 250,
			padding: '1em',
		})
	}

	if(expired === "EXPIRED"){
		Swal.fire({
			type: 'info',
			text: 'Session anda telah habis !',
			allowOutsideClick: false,
		})
	}

    if(permission == "FAILED"){
		Swal.fire({
			type: 'info',
			text: 'Akun ini belum memiliki menu !',
			allowOutsideClick: false,
		})
	}
});

const doSubmit = () => {
	let url   = '{{ route("login") }}',
    	form  = $('form').serialize();
    
	$.ajax({
		url		: url,
		data	: form,
		method	: 'POST',
		dataType: 'JSON',
		cache	: false,
		beforeSend: function () {
			$('#loader-screen').fadeIn();
		},
		success: function (data) {
			if(data['status'] == 'VALIDATION'){
				$(".result").html('<div class="alert alert-danger"><b>'+ data['result'] +'</b></div>');
				$(".result").slideDown();

				setTimeout(function (){
					$(".result").slideUp();
				},2.5 * 1000) // 1000 is Second;

			}else if(data['status'] == 'FAILED'){
				$(".result").html('<div class="alert alert-danger text-center"><b>'+ data['notice'] +'</b></div>');
				$(".result").slideDown();

				setTimeout(function (){
					$(".result").slideUp();
				},2.5 * 1000) // 1000 is Second;
			}else{
				document.location.href = "home";
			}
		},
		complete: function (response) {
			$('#loader-screen').fadeOut();
		}
	});
}
</script>
@endif

<!-- HOME -->
@if(Request::segment(1) == 'home')
<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	$('.dropify').dropify({
		messages: {
			default: 'Drag atau drop untuk memilih gambar',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'Ooops, terjadi kesalahan.'
		}
	});

	// FULLCALENDAR
	let data = '{!! json_encode($list_activity) !!}',
		decode = JSON.parse(data);

	let listEvent	= '';

	let calendarEl = document.getElementById('calendar');
	let calendar = new FullCalendar.Calendar(calendarEl, {
		timeZone: 'UTC',
		initialView: 'dayGridMonth',
		eventDidMount: function(info) {
			console.log(info)
			
			$(info.el).tooltip({ 
				title: info.event.extendedProps.description,
				content: info.event.extendedProps.description,
				placement: "top",
				trigger: "hover",
				container: "body"
			});
		},
		themeSystem: "Flatly",
		displayEventEnd: true,
		views: {
			dayGridMonth: { buttonText: 'Month' },
			listMonth: { buttonText: 'List Month' }
		},
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'dayGridMonth,listMonth',
		},
		eventTimeFormat: {
			hour: '2-digit',
			minute: '2-digit',
			meridiem: false
		},
		events: decode,
		// events: [
		// 	{
		// 		title: 'All Day Event',
		// 		start: '2022-10-01'
		// 	},
		// 	{
		// 		title: 'Long Event',
		// 		start: '2021-04-07',
		// 		end: '2021-04-10'
		// 	},
		// 	{
		// 		groupId: '999',
		// 		title: 'Repeating Event',
		// 		start: '2021-04-09T16:00:00'
		// 	},
		// 	{
		// 		groupId: '999',
		// 		title: 'Repeating Event',
		// 		start: '2021-04-16T16:00:00'
		// 	},
		// 	{
		// 		title: 'Conference',
		// 		start: '2021-04-11',
		// 		end: '2021-04-13'
		// 	},
		// 	{
		// 		title: 'Meeting',
		// 		start: '2022-10-03T10:30:00',
		// 		end: '2022-10-04T12:30:00'
		// 	},
		// 	{
		// 		title: 'Lunch',
		// 		start: '2021-04-12T12:00:00'
		// 	},
		// 	{
		// 		title: 'Meeting',
		// 		start: '2021-04-12T14:30:00'
		// 	},
		// 	{
		// 		title: 'Birthday Party',
		// 		start: '2021-04-13T07:00:00'
		// 	},
		// 	{
		// 		title: 'Click for Google',
		// 		url: 'http://google.com/',
		// 		start: '2022-10-02'
		// 	}
		// ]
	});

	calendar.render();
});

$(function() {
	let tableData	= "",
		url     	= "{{ url('home/get_user_list') }}";

	tableData	= [
		{ mData: 'no', className: "align-middle text-center" },
		{ mData: 'username', className: "align-middle" },
		{ mData: 'role', className: "align-middle" },
		{ mData: 'email', className: "align-middle" },
		{ mData: 'status', className: "align-middle" },
		{ mData: 'updated_at', className: "align-middle" },
	];

	let table   = $('#datatable').DataTable({
		"bDestroy"      : true,
		"responsive"    : true,
		"processing"    : true, //Feature control the processing indicator.
		"language"      : {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"order"         : [], //Initial no order.
		"deferRender"   : true,
		// Load data for the table's content from an Ajax source
		"ajax"          : {
			"url": url,
			"type": "GET"
		},
		//Set column definition initialisation properties.
		"columnDefs"    : [
		{ 
			"targets": [ 0 ], //first column / numbering column
			"orderable": true, //set not orderable
		},
		],
		"aoColumns"     : tableData,
		"lengthMenu"    : [ 10, 25, 50, 75, 100 ],
		"pageLength"    : 10,
	}); 
});
</script>
@endif

<!-- REGISTER -->
@if(Request::segment(1) == 'register')
<script type="text/javascript">
const doRegister = () => {
    let url     = "{{ route('register') }}",
        form    = $("#form").serialize();
  
    $.ajax({
        type    : "POST",
        url     : url,
        data    : form,
        dataType: "JSON",
        beforeSend: function() {
            $('#register').prop('disabled', true);

            $("#result").hide();
        },
        success: function (data){
            $("#result").show();

            if (data['status'] == "SUCCESS"){
                $("#result").html(data['result']);
            }else{
                $("#result").html(data['result']);
            }
        },
        complete: function() {
            $('#register').prop('disabled', false);
        }
    });
} 
</script>
@endif

<!-- USER MANAGEMENT -->
@if(Request::segment(1) == 'user_management')
<script type="text/javascript">
$(document).ready(function() {
	let tableData	= "",
		url     	= "{{ url('user_management/get_user_list') }}";

	tableData	= [
		{ mData: 'no', className: "align-middle text-center" },
		{ mData: 'username', className: "align-middle" },
		{ mData: 'role', className: "align-middle" },
		{ mData: 'email', className: "align-middle" },
		{ mData: 'action', className: "align-middle text-center pt-3", width: '27.5%'},
	];

	let table   = $('#datatable').DataTable({
		"bDestroy"      : true,
		"responsive"    : true,
		"processing"    : true, //Feature control the processing indicator.
		"language"      : {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"order"         : [], //Initial no order.
		"deferRender"   : true,
		// Load data for the table's content from an Ajax source
		"ajax"          : {
			"url": url,
			"type": "GET"
		},
		//Set column definition initialisation properties.
		"columnDefs"    : [
		{ 
			"targets": [ 0 ], //first column / numbering column
			"orderable": true, //set not orderable
		},
		],
		"aoColumns"     : tableData,
		"lengthMenu"    : [ 10, 25, 50, 75, 100 ],
		"pageLength"    : 10,
	}); 
});

const viewCreate = () => {
	let id				= 0;
		url     		= "{{ url('user_management/get_data_user') }}/"+id,
		dataForm		= "";

	$('#modal-create-user').modal('show');
	$("#form-create-user")[0].reset();

	$.ajax({
		url: url,
		type: "GET",
		beforeSend: function() {

		},
		success: function(data) {
			let option	= "";

			$.each( data["role"], function( key, value ) {
				option	+= '<option value="'+value["id"]+'">'+value["id"]+'. '+value["name"]+'</option>';
			});

			dataForm	= 
			'<div class="row">'+
				'<div class="col-md-12">'+
					'<div class="form-group">'+
						'<label for="role">Role <span class="required">*</span></label>'+
						'<select name="role" class="form-control" id="role">'+
							'<option value="">--- Select Role ---</option>'+
							option+
						'</select>'+
					'</div>'+
					'<div class="form-group">'+
						'<label for="name">Nama <span class="required">*</span></label>'+
						'<input type="text" name="name" class="form-control" id="name" placeholder="Nama">'+
					'</div>'+
					'<div class="form-group">'+
						'<label for="job">Job <span class="required">*</span></label>'+
						'<input type="text" name="job" class="form-control" id="job" placeholder="Job">'+
					'</div>'+
					'<div class="form-group">'+
						'<label for="username">Username <span class="required">*</span></label>'+
						'<input type="text" name="username" class="form-control" id="username" placeholder="Username">'+
					'</div>'+
					'<div class="form-group">'+
						'<label for="email">Email <span class="required">*</span></label>'+
						'<input type="email" name="email" class="form-control" id="email" placeholder="Email">'+
					'</div>'+
					'<div class="form-group">'+
						'<label for="password">Password <span class="required">*</span></label>'+
						'<input type="password" name="password" class="form-control" id="password" placeholder="Password">'+
					'</div>'+
				'</div>'+
			'</div>';

			$("#data-create-user").html(dataForm);
			$("#button-create-footer-user").html(
			'<div class="container">'+
				'<div class="row">'+
					'<div class="col-md-4 offset-md-3">'+
						'<button class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>'+
					'</div>'+
					'<div class="col-md-4">'+
						'<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Submit</button>'+
					'</div>'+
				'</div>'+
			'</div>');
		}
	})
}

const viewEdit = (e) => {
	let id			= $(e).val(),
		url			= "{{ url('user_management/get_data_user') }}/"+id,
		dataForm	= "",
		option		= "";

	$('#modal-edit-user').modal('show');
		
	$.get(url, function( data ) {
		$.each( data.role, function( key, value ) {
			let selected	= (parseInt(data['user']['role_id']) === parseInt(value["id"]) ? 'selected' : '');

			option	+= '<option value="'+value["id"]+'" '+selected+'>'+value["id"]+'. '+value["name"]+'</option>';
		});

		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="role">Role <span class="required">*</span></label>'+
					'<select name="role" class="form-control" id="role">'+
						'<option value="">--- Select Role ---</option>'+
						option+
					'</select>'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="name">Name <span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Name" value="'+data.profile.name+'">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="job">Job <span class="required">*</span></label>'+
					'<input type="text" name="job" class="form-control" id="job" placeholder="Job" value="'+data.profile.job+'">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="username">Username <span class="required">*</span></label>'+
					'<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="'+data.user.username+'">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="email">Email <span class="required">*</span></label>'+
					'<input type="email" name="email" class="form-control" id="email" placeholder="Email" value="'+data.user.email+'">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="password">Password <span class="required">*</span></label>'+
					'<input type="password" name="password" class="form-control" id="password" placeholder="Password" value="'+data.user.password+'">'+
				'</div>'+
			'</div>'+
		'</div>';

		$("#data-edit-user").html(dataForm);
		$("#button-edit-footer-user").html(
		'<div class="container">'+
			'<div class="row">'+
				'<div class="col-md-4 offset-md-3">'+
					'<button class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>'+
				'</div>'+
				'<div class="col-md-4">'+
					'<button type="submit" id="submit" onclick="doUpdate('+id+');" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Update</button>'+
				'</div>'+
			'</div>'+
		'</div>');
	});
}

const doSubmit = () => {
	let	url 	= "{{ url('user_management/doSubmit') }}",
		form	= $('#form-create-user').serialize();

	$.ajax({
		url: url,
		type: "POST",
		data: form,
		beforeSend: function() {

		},
		success: function(data) {
			if(data['result']['status'] === "SUCCESS"){
				Swal.fire({
					type    : 'success',
					html    : data['result']['message'],
					allowOutsideClick   : false,
					}).then((result) => {
					if (result.value) {
						$('#modal-create-user').modal('hide');
						$("#form-create-user")[0].reset();
						$('#datatable').DataTable().ajax.reload(null, false);
					}
				})
			}else{
				Swal.fire({
					type    : 'error',
					html    : data['result']['message'],
					allowOutsideClick   : false,
				})
			}
		}
	})
}

const doUpdate = (id) => {
	let url     = "{{ url('user_management/doUpdate') }}/"+id,
		form 	= $("#form-edit-user").serialize();

	$.ajax({
		url: url,
		type: "PATCH",
		data: form,
		beforeSend: function() {

		},
		success: function(data) {
			if(data['result']['status'] === "SUCCESS"){
				Swal.fire({
					type    : 'success',
					html    : data['result']['message'],
					allowOutsideClick   : false,
					}).then((result) => {
					if (result.value) {
						$('#modal-edit-user').modal('hide');
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $("#form-edit-user")[0].reset();
					}
				})
			}else{
				Swal.fire({
					type    : 'error',
					html    : data['message'],
					allowOutsideClick   : false,
				})
			}
		}
	})
}

const doRemove = (e) => {
	let	id		= $(e).val(),
		name	= $(e).attr('data-name'),
		url 	= "{{ url('user_management/doRemove') }}/"+id+"/"+name;

	Swal.fire({
		type    : 'warning',
		title	: 'Alert',
		html    : "Apakah anda yakin, mau menghapus data ini ?",
		confirmButtonColor	: '#3085d6',
		cancelButtonColor	: '#d33',
		cancelButtonText	: 'Cancel',
		confirmButtonText	: 'Confirm',
		showCancelButton	: true,
		reverseButtons		: true,
		allowOutsideClick   : false,
		}).then((result) => {
		if (result.value) {
			$.ajax({
				url: url,
				type: "GET",
				beforeSend: function() {

				},
				success: function(data) {
					Swal.fire({
						type	: 'success',
						title	: 'Result',
						html	: data['result'],
						allowOutsideClick   : false,
					}).then((result) => {
						if (result.value) {
							$('#datatable').DataTable().ajax.reload(null, false);
						}
					})
				}
			})
		}
	})
}
</script>
@endif

<!-- CONFIGURATION -->
@if(Request::segment(1) == 'configuration')
<script type="text/javascript">
$(document).ready(function() {
	let tableData	= "",
		URI 		= "{{ Request::segment(2) }}",
		url     	= "{{ url('configuration/getList') }}/"+URI;

	if(URI === "support_department"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}else if(URI === "activity"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'department_name', className: "align-middle", width: '20%' },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'status', className: "align-middle text-center text-sm" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}else if(URI === "activity_type"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}else if(URI === "channel_requestor"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}else if(URI === "requestor"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'type', className: "align-middle" },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'username', className: "align-middle" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}else if(URI === "role"){
		tableData	= [
			{ mData: 'no', className: "align-middle text-center" },
			{ mData: 'name', className: "align-middle" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '12.5%'},
		];
	}

	let table   = $('#datatable').DataTable({
		"bDestroy"      : true,
		"responsive"    : true, 
		"autoWidth"		: false,
		"processing"    : true, //Feature control the processing indicator.
		"language"      : {
			"processing"	: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
		},
		"order"         : [], //Initial no order.
		"deferRender"   : true,
		// Load data for the table's content from an Ajax source
		"ajax"          : {
			"url": url,
			"type": "GET"
		},
		//Set column definition initialisation properties.
		"columnDefs"    : [
		{ 
			"targets": [ 0 ], //first column / numbering column
			"orderable": true, //set not orderable
		},
		],
		"aoColumns"     : tableData,
		"lengthMenu"    : [ 10, 25, 50, 75, 100 ],
		"pageLength"    : 10,
	}); 
});

const viewCreate = (data) => {
	let URI 		= "{{ Request::segment(2) }}",
		dataForm	= "";

	$('#modal-create-'+URI).modal('show');
	
	if(URI === "support_department"){
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="name">Support Department Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Department Name">'+
				'</div>'+
			'</div>'+
		'</div>';
	}else if(URI === "activity"){
		let parsing	= JSON.parse(data),
			option	= "";

		$.each( parsing, function( key, value ) {
			option	+= '<option value="'+value["id"]+'">'+value["id"]+'. '+value["name"]+'</option>';
		});
		
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="support_department_id">Support Department Name<span class="required">*</span></label>'+
					'<select name="support_department_id" class="form-control" id="support_department_id">'+
					'<option value="">---Select Support Department Name---</option>'+
					option+
					'</select>'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="name">Activity Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Activity Name">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="status">Status<span class="required">*</span></label>'+
					'<div class="form-check form-switch">'+
						'<input name="status" class="form-check-input" type="checkbox" id="status">'+
						'<label class="form-check-label" for="status" id="label_status">Inactive</label>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</div>';
	}else if(URI === "activity_type"){
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="name">Activity Type Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Activity Type Name">'+
				'</div>'+
			'</div>'+
		'</div>';
	}else if(URI === "channel_requestor"){
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="name">Channel Requestor Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Channel Requestor Name">'+
				'</div>'+
			'</div>'+
		'</div>';
	}else if(URI === "requestor"){
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="type">Requestor Type<span class="required">*</span></label>'+
					'<select name="type" class="form-control" id="type">'+
					'<option value="">---Select Requestor Type---</option>'+
					'<option value="Telkomsel">Telkomsel</option>'+
					'<option value="Agit">Agit</option>'+
					'</select>'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="name">Requestor Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Requestor Name">'+
				'</div>'+
				'<div class="form-group">'+
					'<label for="name">Requestor Username<span class="required">*</span></label>'+
					'<input type="text" name="username" class="form-control" id="username" placeholder="Requestor Userame">'+
				'</div>'+
			'</div>'+
		'</div>';
	}else if(URI === "role"){
		dataForm	= 
		'<div class="row">'+
			'<div class="col-md-12">'+
				'<div class="form-group">'+
					'<label for="name">Role Name<span class="required">*</span></label>'+
					'<input type="text" name="name" class="form-control" id="name" placeholder="Role Name">'+
				'</div>'+
			'</div>'+
		'</div>';
	}

	$("#data-create-"+URI).html(dataForm);

	$('input[type="checkbox"]').click(function(){
		if($(this).prop("checked") == true){
			$("#label_status").text("Active");
		}
		else if($(this).prop("checked") == false){
			$("#label_status").text("Inactive");
		}
	});

	$("#button-create-footer-"+URI).html('<div class="container">'+
								'<div class="row">'+
								'<div class="col-md-4">'+
									'<button class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>'+
								'</div>'+
									'<div class="col-md-4 offset-md-4">'+
										'<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Submit</button>'+
									'</div>'+
								'</div>'+
							'</div>');
}

const viewEdit = (id) => {
	let URI 		= "{{ Request::segment(2) }}",
		url     	= "{{ url('configuration/view_edit') }}/"+URI+"/"+id,
		dataForm	= "";
	
	$('#modal-edit-'+URI).modal('show');

	$.ajax({
		url: url,
		type: "GET",
		beforeSend: function() {

		},
		success: function(data) {
			if(URI === "support_department"){
				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Department Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Department Name" value="'+data["name"]+'">'+
										'</div>'+
									'</div>'+
								'</div>';
			}else if(URI === "activity"){
				let option		= "",
					selected	= "",
					checked 	= "";

				checked	= (data["activity"]["status"] === "Active" ? "checked" : "");

				$.each( data["support_department"], function( key, value ) {
					selected	= (value["id"] === data["activity"]["support_department_id"]  ? 'selected' : '') ;

					option	+= '<option value="'+value["id"]+'" '+selected+'>'+value["id"]+'. '+value["name"]+'</option>';
				});

				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="support_department_id">Department Name<span class="required">*</span></label>'+
											'<select name="support_department_id" class="form-control" id="support_department_id">'+
											'<option>---Select Support Department Name---</option>'+
											option+
											'</select>'+
										'</div>'+
										'<div class="form-group">'+
											'<label for="name">Activity Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Activity Name" value="'+data["activity"]["name"]+'">'+
										'</div>'+
										'<div class="form-group">'+
											'<label for="status">Status<span class="required">*</span></label>'+
											'<div class="form-check form-switch">'+
												'<input name="status" class="form-check-input" type="checkbox" id="status" '+checked+'>'+
												'<label class="form-check-label" for="status" id="label_status">'+(data["activity"]["status"] === "Active" ? "Active" : "Inactive")+'</label>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
								
			}else if(URI === "activity_type"){
				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Activity Type Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Activity Type Name" value="'+data["name"]+'">'+
										'</div>'+
									'</div>'+
								'</div>';
			}else if(URI === "channel_requestor"){
				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Channel Requestor Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Channel Requestor Name" value="'+data["name"]+'">'+
										'</div>'+
									'</div>'+
								'</div>';
			}else if(URI === "requestor"){
				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="type">Requestor Type<span class="required">*</span></label>'+
											'<select name="type" class="form-control" id="type">'+
											'<option value="">---Select Requestor Type---</option>'+
											'<option value="Telkomsel" '+ (data.type === "Telkomsel" ? "selected" : "") +'>Telkomsel</option>'+
											'<option value="Agit" '+ (data.type === "Agit" ? "selected" : "") +'>Agit</option>'+
											'</select>'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Requestor Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Requestor Name" value="'+data["name"]+'">'+
										'</div>'+
									'</div>'+
								'</div>'+
								'<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Requestor Username<span class="required">*</span></label>'+
											'<input type="text" name="username" class="form-control" id="username" placeholder="Requestor Username" value="'+data["username"]+'">'+
										'</div>'+
									'</div>'+
								'</div>';
			}else if(URI === "role"){
				dataForm	= '<div class="row">'+
									'<div class="col-md-12">'+
										'<div class="form-group">'+
											'<label for="name">Role Name<span class="required">*</span></label>'+
											'<input type="text" name="name" class="form-control" id="name" placeholder="Role Name" value="'+data["name"]+'">'+
										'</div>'+
									'</div>'+
								'</div>';
			}

			$("#data-edit-"+URI).html(dataForm);

			$('input[type="checkbox"]').click(function(){
				if($(this).prop("checked") == true){
					$("#label_status").text("Active");
				}
				else if($(this).prop("checked") == false){
					$("#label_status").text("Inactive");
				}
			});
			
			$("#button-edit-footer-"+URI).html('<div class="container">'+
										'<div class="row">'+
										'<div class="col-md-4">'+
											'<button class="btn btn-danger btn-sm" data-bs-dismiss="modal"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>'+
										'</div>'+
											'<div class="col-md-4 offset-md-4">'+
												'<button type="submit" id="submit" onclick="doUpdate('+id+');" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> Update</button>'+
											'</div>'+
										'</div>'+
									'</div>');
		}
	})
}

const doSubmit = () => {
	let URI 	= "{{ Request::segment(2) }}",
		url     = "{{ url('configuration/doSubmit') }}/"+URI,
		form 	= $("#form-create-"+URI).serialize();

	$.ajax({
		url: url,
		type: "POST",
		data: form,
		beforeSend: function() {

		},
		success: function(data) {
			console.log(data)
			if(data['status'] === "SUCCESS"){
				Swal.fire({
					type    : 'success',
					html    : data['message'],
					allowOutsideClick   : false,
					}).then((result) => {
					if (result.value) {
						$('#modal-create-'+URI).modal('hide');
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $("#form-create-"+URI)[0].reset();
					}
				})
			}else{
				Swal.fire({
					type    : 'error',
					html    : data['message'],
					allowOutsideClick   : false,
				})
			}
		}
	})
}

const doUpdate = (id) => {
	let URI 	= "{{ Request::segment(2) }}",
		url     = "{{ url('configuration/doUpdate') }}/"+URI+"/"+id,
		form 	= $("#form-edit-"+URI).serialize();

	$.ajax({
		url: url,
		type: "PATCH",
		data: form,
		beforeSend: function() {

		},
		success: function(data) {
			if(data['status'] === "SUCCESS"){
				Swal.fire({
					type    : 'success',
					html    : data['message'],
					allowOutsideClick   : false,
					}).then((result) => {
					if (result.value) {
						$('#modal-edit-'+URI).modal('hide');
                        $('#datatable').DataTable().ajax.reload(null, false);
                        $("#form-edit-"+URI)[0].reset();
					}
				})
			}else{
				Swal.fire({
					type    : 'error',
					html    : data['message'],
					allowOutsideClick   : false,
				})
			}
		}
	})
}
</script>
@endif

<!-- LOGBOOK -->
@if(Request::segment(1) == 'logbook')
<script type="text/javascript">
	$(document).ready(function() {
		let tableData	= "",
			url     	= "{{ url('logbook/get_list_activity') }}";

		tableData	= [
			{ mData: 'no', className: "align-middle text-center text-sm" },
			{ mData: 'support_department', className: "align-middle text-sm" },
			{ mData: 'activity_name', className: "align-middle text-sm" },
			{ mData: 'activity_type', className: "align-middle text-sm" },
			{ mData: 'detail_activity', className: "align-middle text-sm" },
			// { mData: 'remarks', className: "align-middle text-sm" },
			{ mData: 'start_date', className: "align-middle text-sm" },
			{ mData: 'end_date', className: "align-middle text-sm" },
			{ mData: 'requestor', className: "align-middle text-sm" },
			// { mData: 'channel_requestor', className: "align-middle text-sm" },
			// { mData: 'executor', className: "align-middle text-sm" },
			// { mData: 'url', className: "align-middle text-sm" },
			// { mData: 'additional_info', className: "align-middle text-sm" },
			{ mData: 'action', className: "align-middle text-center pt-3", width: '30%'},
		];

		let button	= [
			{
				extend: 'excel',
				text: 'Export',
				className: 'btn btn-md btn-primary',
				title: 'Daftar Informasi List Activity',
				customize: function ( xlsx ) {
					let sheet = xlsx.xl.worksheets['sheet1.xml'];

					let loop = 0;
					$('row', sheet).each(function () {
						if (loop < 2) {
							$('row c[r*="2"]', sheet).attr( 's', '27' );
						}else{
							$(this).find('c').attr('s', '25');
						}
						loop++;
					});
				},
				exportOptions: {
					columns: 'th:not(:last-child)'
				}  
			},
		];

		let table   = $('#datatable').DataTable({
			"bDestroy"      : true,
			"scrollX"		: true,
			"processing"    : true, //Feature control the processing indicator.
			"language"      : {
				processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
			},
			"order"         : [], //Initial no order.
			"deferRender"   : true,
			// Load data for the table's content from an Ajax source
			"ajax"          : {
				"url": url,
				"type": "GET"
			},
			"dom": 'Bfrtip',
			"buttons": button,
			//Set column definition initialisation properties.
			"columnDefs"    : [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": true, //set not orderable
			},
			],
			"aoColumns"     : tableData,
			"lengthMenu"    : [ 10, 25, 50, 75, 100 ],
			"pageLength"    : 10,
		}); 
		
		let url_export = "{{ url('logbook/doExportTable') }}";

		$('.buttons-excel').replaceWith(`
		<a href="`+url_export+`" class="btn btn-sm btn-shadow btn btn-primary""> 
			<i class="fa fa-download"></i> 
			Ekspor
		</a>
		`);

		$("#show-form").hide();
		$("#show-upload-file").hide();
	});

	let changeValue	= "";
	$( "#input_type" ).change(function() {
		changeValue	= this.value;

		if(changeValue	=== "form"){
			$("#show-form").slideUp(500, function() {
				$("#show-form").delay(500).slideDown();
				$("#show-upload-file").slideUp();
				$("#show-activity").slideUp();
			}); 

			$("#button-create-footer-list-activity").slideUp(500, function() {
				$("#button-create-footer-list-activity").html(`
				<div class="container">
					<div class="row">
						<div class="col-md-4 offset-md-3">
							<button class="btn btn-danger" onclick="location.href= '{{ url("logbook/") }}' "><i class="fa fa-ban me-1"></i> Cancel</button>
						</div>
						<div class="col-md-4">
							<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success"><i class="fa fa-check me-1"></i> Submit</button>
						</div>
					</div>
				</div>`).delay(500).slideDown();
			}); 
		}else if(changeValue === "upload-file"){
			$("#show-upload-file").slideUp(500, function() {
				$("#show-upload-file").delay(500).slideDown();
				$("#show-form").slideUp();
			});
			
			$("#button-create-footer-list-activity").slideUp(500, function() {
				$("#button-create-footer-list-activity").html(`
					<div class="container">
						<div class="row">
							<div class="col-md-4 offset-md-3">
								<button class="btn btn-danger" onclick="location.href= '{{ url("logbook/") }}' "><i class="fa fa-ban me-1"></i> Cancel</button>
							</div>
							<div class="col-md-4">
								<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success"><i class="fa fa-check me-1"></i> upload</button>
							</div>
						</div>
					</div>`).delay(500).slideDown();
			}); 
		}else{
			$("#show-form").slideUp();
			$("#show-upload-file").slideUp();
			$("#button-create-footer-list-activity").html("");
		}
	});

	$("#support_department_name").change(function() {
		changeValue	= this.value;

		$("#show-activity").slideUp();
		$("#show-activity").slideDown();

		Swal.fire({
			title   : 'Memuat . . .',
			allowOutsideClick   : false,
			timer: 1000,
			onBeforeOpen    : () => {
				Swal.showLoading()
			},
		});

		$.get("{{ url('logbook/get_department_activity') }}/"+changeValue,  // url
		function (data, textStatus, jqXHR) {  // success callback
			let optionActivity	= "";
			
			$.each(data["activity"], function( key, value ) {
				optionActivity	+= '<option value="'+value["id"]+'">'+value["id"]+'. '+value["name"]+'</option>';
			});
	
			$("#show-activity").html(
			'<div class="form-group">'+
				'<label for="activity_name">Activity Name <span class="required">*</span></label>'+
				'<select name="activity_name" class="form-select" id="activity_name" data-placeholder="Select Activity Name">'+
					'<option></option>'+
					optionActivity+
				'</select>'+
			'</div>');

			$('#activity_name').select2({
				theme: "bootstrap-5",
				width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
				placeholder: $( this ).data( 'placeholder' ),
				dropdownParent: $( '#activity_name' ).parent(),
			});
		});
	});

	$("#download-template").click(function() {
		Swal.fire({
			title   : 'Memuat . . .',
			allowOutsideClick   : false,
			timer: 1000,
			onBeforeOpen    : () => {
				Swal.showLoading()
			},
		});

		window.location	= "{{ url('logbook/doExportTemplate') }}"; 
	});

	$('.dropify').dropify({
		messages: {
			default: 'Drag atau drop untuk memilih file',
			replace: 'Ganti',
			remove:  'Hapus',
			error:   'Ooops, terjadi kesalahan.'
		}
	});
	
	let start_picker = flatpickr('input[name=start_date]', {
		enableTime: true,
		dateFormat: "Y-m-d H:i",
		timeFormat: "H:i",
		altInput: true,
		time_24hr: true,
		allowInvalidPreload: false,
		onClose: function(selectedDates, dateStr, instance) {
			end_picker.set('minDate', dateStr);
		},
	});

	let end_picker = flatpickr('input[name=end_date]', {
		enableTime: true,
		dateFormat: "Y-m-d H:i",
		timeFormat: "H:i",
		altInput: true,
		time_24hr: true,
		allowInvalidPreload: false,
		onClose: function(selectedDates, dateStr, instance) {
			start_picker.set('maxDate', dateStr);
		},
	});
	
	function ConvertDateFormat(d, t) {
		var dt = d.split('-');

		return dt[1] + '/' + dt[2] + '/' + dt[0] + ' ' + t;
	}
	
	$( "input[name=start_date]" ).change(function() {
		// let start_date 	= $(this).val();
		// let end_date	= $( "input[name=end_date]" ).val();

		let exp_start_date	= $( this ).val().split(' ');
		let exp_end_date 	= $( "input[name=end_date]" ).val().split(' ');

		let start = new Date(ConvertDateFormat(exp_start_date[0], exp_start_date[1]));
		let end = new Date(ConvertDateFormat(exp_end_date[0], exp_end_date[1]));

		let diff 		= new Date(end - start);
		let days 		= Math.floor(diff / 1000 / 60 / 60 / 24);
		let hours 		= Math.floor((diff % (1000 * 60 * 60 * 24)) / 1000 / 60 / 60);
		let duration	= ((days * 24) + hours);

		$("#duration").val(duration);
	});

	$( "input[name=end_date]" ).change(function() {
		let exp_start_date	= $( "input[name=start_date]" ).val().split(' ')
		let exp_end_date 	= $(this).val().split(' ');

		let start = new Date(ConvertDateFormat(exp_start_date[0], exp_start_date[1]));
		let end = new Date(ConvertDateFormat(exp_end_date[0], exp_end_date[1]));

		let diff 		= new Date(end - start);
		let days 		= Math.floor(diff / 1000 / 60 / 60 / 24);
		let hours 		= Math.floor((diff % (1000 * 60 * 60 * 24)) / 1000 / 60 / 60);
		let duration	= ((days * 24) + hours);

		$("#duration").val(duration);
	});

	$('#support_department_name').select2({
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		dropdownParent: $( '#support_department_name' ).parent(),
	});

	$('#activity_type').select2({
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		dropdownParent: $( '#activity_type' ).parent(),
	});

	$('#channel_requestor').select2({
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		dropdownParent: $( '#channel_requestor' ).parent(),
	});

	$('#requestor').select2({
		theme: "bootstrap-5",
		width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
		placeholder: $( this ).data( 'placeholder' ),
		closeOnSelect: true,
	});

	$('#remove-file').on('click', function() {
		$('#upload_file').val('');
	});

	// const viewCreate = () => {
	// 	let url     		= "{{ url('logbook/get_data_create') }}",
	// 		dataForm		= "";

	// 	$('#modal-create-list-activity').modal('show');
		
	// 	$.ajax({
	// 		url: url,
	// 		type: "GET",
	// 		beforeSend: function() {

	// 		},
	// 		success: function(data) {
	// 			dataForm	= 
	// 			'<div class="row">'+
	// 				'<div class="col-md-4">'+
	// 					'<div class="form-group">'+
	// 						'<label for="input_type">Input Type<span class="required">*</span></label>'+
	// 						'<select type="text" name="input_type" class="form-control" id="input_type"">'+
	// 							'<option>--- Select Input Type ---</option>'+
	// 							'<option value="form">Form</option>'+
	// 							'<option value="upload-file">Upload File</option>'+
	// 						'</select>'+
	// 					'</div>'+
	// 				'</div>'+
	// 			'</div>'+
	// 			'<div class="row" id="show-form">'+
	// 				'<div class="col-md-12">'+
	// 					'<div class="card-header pb-4 text-center">'+
	// 						'<h5>Create Form</h5>'+
	// 					'</div>'+
	// 					'<form id="page-form-service">'+
	// 						'<div class="row">'+
	// 							'<div class="col-md-5">'+
	// 								'<div class="form-group">'+
	// 									'<label for="start_date">Start Date <span class="required">*</span></label>'+
	// 									'<input type="text" class="form-control" name="start_date" required data-alt-format="d-m-Y H:i">'+
	// 								'</div>'+
	// 							'</div>'+
	// 							'<div class="col-md-5">'+
	// 								'<div class="form-group">'+
	// 									'<label for="end_date">End Date <span class="required">*</span></label>'+
	// 									'<input type="text" class="form-control" name="end_date" required data-alt-format="d-m-Y H:i">'+
	// 								'</div>'+
	// 							'</div>'+
	// 							'<div class="col-md-2">'+
	// 								'<div class="form-group">'+
	// 									'<label for="duration">Duration <span class="required">*</span></label>'+
	// 									'<input type="text" class="form-control" name="duration" required id="duration" readonly>'+
	// 								'</div>'+
	// 							'</div>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="support_department_name">Support Department Name <span class="required">*</span></label>'+
	// 							'<select name="support_department_name" class="form-select" id="support_department_name" data-placeholder="Select Support Department Name">'+
	// 								'<option></option>'+
	// 								data["support_department"]+
	// 							'</select>'+
	// 						'</div>'+
	// 						'<div id="show-activity"></div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="activity_type">Activity Type <span class="required">*</span></label>'+
	// 							'<select name="activity_type" class="form-select" id="activity_type" data-placeholder="Select Activity Type">'+
	// 								'<option></option>'+
	// 								data["activity_type"]+
	// 							'</select>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="detail_activity">Detail Activity <span class="required">*</span></label>'+
	// 							'<textarea name="detail_activity" class="form-control" id="detail_activity" placeholder="Detail Activity"></textarea>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="notes">Remarks (Optional)</label>'+
	// 							'<textarea name="remarks" class="form-control" id="remarks" placeholder="Remarks"></textarea>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="requestor">Requestor <span class="required">*</span></label>'+
	// 							'<select name="requestor[]" class="form-select" id="requestor" data-placeholder="Select Requestor" multiple>'+
	// 								'<option></option>'+
	// 								data["requestor"]+
	// 							'</select>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="channel_requestor">Channel Requestor <span class="required">*</span></label>'+
	// 							'<select name="channel_requestor" class="form-select" id="channel_requestor" data-placeholder="Select Channel Requestor">'+
	// 								'<option></option>'+
	// 								data["channel_requestor"]+
	// 							'</select>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="executor">Executor <span class="required">*</span></label>'+
	// 							'<input type="text" name="executor" class="form-control" id="executor" placeholder="Executor" value="{{ Auth::user()->profile->name }}" readonly>'+
	// 						'</div>'+
	// 						'<div class="form-group">'+
	// 							'<label for="url">Link Document (sharepoint, gdocs, others)</label>'+
	// 							'<input type="text" name="url" class="form-control" id="url" placeholder="Url">'+
	// 						'</div>'+
	// 					'</form>'+
	// 				'</div>'+
	// 			'</div>'+
	// 			'<div class="row" id="show-upload-file">'+
	// 				'<div class="card-header pb-4 text-center">'+
	// 					'<h5>Form Upload Service</h5>'+
	// 				'</div>'+
	// 				'<nav class="pb-4">'+
	// 					'<div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">'+
	// 						'<a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1">'+
	// 						'Step 1'+
	// 						'<br>'+
	// 						'<label class="text-white">Upload File</label>'+
	// 						'</a>'+
	// 						'<a class="nav-link disabled" id="step2-tab" data-bs-toggle="tab" href="#step2">'+
	// 						'Step 2'+ 
	// 						'<br>'+
	// 						'<label class="text-white">Validation, Verification & Revisi Data</label>'+
	// 						'</a>'+
	// 					'</div>'+
	// 				'</nav>'+
	// 				'<div class="col-md-12">'+
	// 					'<div class="tab-content py-4">'+
	// 						'<div class="tab-pane fade show active" id="step1">'+
	// 							'<div class="alert alert-info" role="alert">'+
	// 								'<h6>INFORMASI !</h6>'+ 
	// 								'<p>Pemberitahuan Service Request yang diupload harap sama dengan template yang di sediakan & data disesuaikan dengan headernya tanpa merubah posisi kolom.</p>'+
	// 								'<button type="button" class="btn btn-success btn-sm" id="download-template">Download Template</button>'+
	// 							'</div>'+
	// 							'<div class="row">'+
	// 								'<form id="page-form-upload-file" class="d-flex justify-content-center">'+
	// 									'<div class="col-6">'+
	// 										'<div class="form-group">'+
	// 											'<label for="upload_file">Upload File</label>'+
	// 											'<div class="input-group">'+
	// 												'<input type="file" name="upload_file" class="form-control-sm dropify" id="upload_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" data-allowed-file-extensions="xlsx">'+
	// 												'<button type="button" class="btn btn-sm btn-secondary" id="remove-file">Remove</button>'+
	// 											'</div>'+
	// 										'</div>'+
	// 									'</div>'+
	// 								'</form>'+
	// 							'</div>'+
	// 						'</div>'+
	// 						'<div class="tab-pane fade" id="step2">'+
	// 							'<div class="table-responsive p-3">'+
	// 								'<form id="page-verification-data">'+
	// 									'<table class="table table-display table-bordered nowrap" id="table-list-activity" width="100%">'+
	// 										'<thead>'+
	// 											'<tr>'+
	// 												'<th>No</th>'+
	// 												'<th>Support Department Name</th>'+
	// 												'<th>Activity Name</th>'+
	// 												'<th>Activity Type</th>'+
	// 												'<th>Detail Activity</th>'+
	// 												'<th>Remarks</th>'+
	// 												'<th>Start Date</th>'+
	// 												'<th>End Date</th>'+
	// 												'<th>Duration</th>'+
	// 												'<th>Requestor</th>'+
	// 												'<th>Channel Requestor</th>'+
	// 												'<th>Executor</th>'+
	// 												'<th>Url</th>'+
	// 												'<th>Additional Info</th>'+
	// 											'</tr>'+
	// 										'</thead>'+
	// 										'<tbody>'+
	// 										'</tbody>'+
	// 									'</table>'+
	// 								'</form>'+
	// 							'</div>'+
	// 						'</div>'+
	// 					'</div>'+
	// 				'</div>'+
	// 			'</div>';

	// 			$("#data-create-list-activity").html(dataForm);
				
	// 			$("#show-form").hide();
	// 			$("#show-upload-file").hide();

	// 			let changeValue	= "";
	// 			$( "#input_type" ).change(function() {
	// 				changeValue	= this.value;

	// 				if(changeValue	=== "form"){
	// 					$("#show-form").slideUp(500, function() {
	// 						$("#show-form").delay(500).slideDown();
	// 						$("#show-upload-file").slideUp();
	// 						$("#show-activity").slideUp();
	// 					}); 

	// 					$("#button-create-footer-list-activity").slideUp(500, function() {
	// 						$("#button-create-footer-list-activity").html(
	// 						'<div class="container">'+
	// 							'<div class="row">'+
	// 								'<div class="col-md-4 offset-md-3">'+
	// 									'<button class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban me-1"></i> Cancel</button>'+
	// 								'</div>'+
	// 								'<div class="col-md-4">'+
	// 									'<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success"><i class="fa fa-check me-1"></i> Submit</button>'+
	// 								'</div>'+
	// 							'</div>'+
	// 						'</div>').delay(500).slideDown();
	// 					}); 
	// 				}else if(changeValue === "upload-file"){
	// 					$("#show-upload-file").slideUp(500, function() {
	// 						$("#show-upload-file").delay(500).slideDown();
	// 						$("#show-form").slideUp();
	// 					});
						
	// 					$("#button-create-footer-list-activity").slideUp(500, function() {
	// 						$("#button-create-footer-list-activity").html(
	// 						'<div class="container">'+
	// 							'<div class="row">'+
	// 								'<div class="col-md-4 offset-md-3">'+
	// 									'<button class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban me-1"></i> Cancel</button>'+
	// 								'</div>'+
	// 								'<div class="col-md-4">'+
	// 									'<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success"><i class="fa fa-check me-1"></i> upload</button>'+
	// 								'</div>'+
	// 							'</div>'+
	// 						'</div>').delay(500).slideDown();
	// 					}); 
	// 				}else{
	// 					$("#show-form").slideUp();
	// 					$("#show-upload-file").slideUp();
	// 					$("#button-create-footer-list-activity").html("");
	// 				}
	// 			});

	// 			$("#support_department_name").change(function() {
	// 				changeValue	= this.value;
					
	// 				$("#show-activity").slideUp();
	// 				$("#show-activity").slideDown();

	// 				$.get("{{ url('logbook/get_department_activity') }}/"+changeValue,  // url
	// 				function (data, textStatus, jqXHR) {  // success callback
	// 					let optionActivity	= "";

	// 					$.each(data["activity"], function( key, value ) {
	// 						optionActivity	+= '<option value="'+value["id"]+'">'+value["id"]+'. '+value["name"]+'</option>';
	// 					});
				
	// 					$("#show-activity").html(
	// 					'<div class="form-group">'+
	// 						'<label for="activity_name">Activity Name <span class="required">*</span></label>'+
	// 						'<select name="activity_name" class="form-select" id="activity_name" data-placeholder="Select Activity Name">'+
	// 							'<option></option>'+
	// 							optionActivity+
	// 						'</select>'+
	// 					'</div>');

	// 					$('#activity_name').select2({
	// 						theme: "bootstrap-5",
	// 						width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
	// 						placeholder: $( this ).data( 'placeholder' ),
	// 						dropdownParent: $( '#activity_name' ).parent(),
	// 					});
	// 				});
	// 			});

	// 			$("#download-template").click(function() {
	// 				Swal.fire({
	// 					title   : 'Memuat . . .',
	// 					allowOutsideClick   : false,
	// 					timer: 1000,
	// 					onBeforeOpen    : () => {
	// 						Swal.showLoading()
	// 					},
	// 				});

	// 				window.location	= "{{ url('logbook/doExportTemplate') }}"; 
	// 			});

	// 			$('.dropify').dropify({
	// 				messages: {
	// 					default: 'Drag atau drop untuk memilih gambar',
	// 					replace: 'Ganti',
	// 					remove:  'Hapus',
	// 					error:   'Ooops, terjadi kesalahan.'
	// 				}
	// 			});
				
	// 			flatpickr('input[name=start_date]', {
	// 				enableTime: true,
	// 				dateFormat: "Y-m-d H:i",
	// 				timeFormat: "H:i",
	// 				altInput: true,
	// 				time_24hr: true,
	// 			});

	// 			flatpickr('input[name=end_date]', {
	// 				enableTime: true,
	// 				dateFormat: "Y-m-d H:i",
	// 				timeFormat: "H:i",
	// 				altInput: true,
	// 				time_24hr: true,
	// 			});
				
	// 			function ConvertDateFormat(d, t) {
	// 				var dt = d.split('-');

	// 				return dt[1] + '/' + dt[2] + '/' + dt[0] + ' ' + t;
	// 			}
				
	// 			$( "input[name=start_date]" ).change(function() {
	// 				let start_date 	= $(this).val();
	// 				let end_date	= $( "input[name=end_date]" ).val();
	// 			});

	// 			$( "input[name=end_date]" ).change(function() {
	// 				let exp_start_date	= $( "input[name=start_date]" ).val().split(' ')
	// 				let exp_end_date 	= $(this).val().split(' ');

	// 				let start = new Date(ConvertDateFormat(exp_start_date[0], exp_start_date[1]));
	// 				let end = new Date(ConvertDateFormat(exp_end_date[0], exp_end_date[1]));

	// 				let diff 		= new Date(end - start);
	// 				let days 		= Math.floor(diff / 1000 / 60 / 60 / 24);
	// 				let hours 		= Math.floor((diff % (1000 * 60 * 60 * 24)) / 1000 / 60 / 60);
	// 				let duration	= ((days * 24) + hours);

	// 				$("#duration").val(duration);
	// 			});
		
	// 			$('#support_department_name').select2({
	// 				theme: "bootstrap-5",
	// 				width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
	// 				placeholder: $( this ).data( 'placeholder' ),
	// 				dropdownParent: $( '#support_department_name' ).parent(),
	// 			});

	// 			$('#activity_type').select2({
	// 				theme: "bootstrap-5",
	// 				width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
	// 				placeholder: $( this ).data( 'placeholder' ),
	// 				dropdownParent: $( '#activity_type' ).parent(),
	// 			});

	// 			$('#channel_requestor').select2({
	// 				theme: "bootstrap-5",
	// 				width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
	// 				placeholder: $( this ).data( 'placeholder' ),
	// 				dropdownParent: $( '#channel_requestor' ).parent(),
	// 			});

	// 			$('#requestor').select2({
	// 				theme: "bootstrap-5",
	// 				width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
	// 				placeholder: $( this ).data( 'placeholder' ),
	// 				closeOnSelect: true,
	// 			});

	// 			$('#remove-file').on('click', function() {
	// 				$('#upload_file').val('');
	// 			});
	// 		}
	// 	})

	// }

	const doSubmit = () => {
		let input_type	= $("#input_type").val(),
			url			= "",
			formData	= "";

		if(input_type === "upload-file"){
			url 		= "{{ url('logbook/doSubmit') }}/upload",
			formData 	= new FormData($('#page-form-upload-file')[0]);
			formData.append("_token", '{{ csrf_token() }}');
		}else{
			url 		= "{{ url('logbook/doSubmit') }}/form",
			formData 	= new FormData($('#page-form-service')[0]);
			formData.append("_token", '{{ csrf_token() }}');
		}

		$.ajax({
			url: url,
			type: "POST",
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			beforeSend: function() {
				Swal.fire({
					title   : 'Memuat . . .',
					allowOutsideClick   : false,
					onBeforeOpen    : () => {
						Swal.showLoading()
					},
				});
			},
			success: function(data) {
				if(data['result']['status'] === "SUCCESS"){
					Swal.fire({
						type    : 'success',
						html    : data['result']['message'],
						allowOutsideClick   : false,
						}).then((result) => {
						if (result.value) {
							if(input_type === "upload-file"){
								Swal.fire({
									showConfirmButton: false,
									timer: 11,
								})

								$("#step1-tab").click(function() {
									$("#button-create-footer-list-activity").slideUp(500, function() {
										$("#button-create-footer-list-activity").html(
										'<div class="container">'+
											'<div class="row">'+
												'<div class="col-md-4 offset-md-3">'+
													'<button class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban me-1"></i> Cancel</button>'+
												'</div>'+
												'<div class="col-md-4">'+
													'<button type="submit" id="submit" onclick="doSubmit();" class="btn btn-success"><i class="fa fa-check me-1"></i> upload</button>'+
												'</div>'+
											'</div>'+
										'</div>').delay(500).slideDown();
									}); 
								})

								$("#step2-tab").removeClass("disabled");
								document.querySelector('#step2-tab').click();

								$("#button-create-footer-list-activity").slideUp(500, function() {
									$("#button-create-footer-list-activity").html(
									'<div class="container">'+
										'<div class="row">'+
											'<div class="col-md-4 offset-md-3">'+
												'<button class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban me-1"></i> Cancel</button>'+
											'</div>'+
											'<div class="col-md-4">'+
												'<button type="button" onclick="doImport();" class="btn btn-primary"><i class="fa fa-check me-1"></i> Import</button>'+
											'</div>'+
										'</div>'+
									'</div>').delay(500).slideDown();
								}); 
								
								$("#step2-tab").click(function() {
									$("#button-create-footer-list-activity").slideUp(500, function() {
										$("#button-create-footer-list-activity").html(
										'<div class="container">'+
											'<div class="row">'+
												'<div class="col-md-4 offset-md-3">'+
													'<button class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-ban me-1"></i> Cancel</button>'+
												'</div>'+
												'<div class="col-md-4">'+
													'<button type="button" onclick="doImport();" class="btn btn-primary"><i class="fa fa-check me-1"></i> Import</button>'+
												'</div>'+
											'</div>'+
										'</div>').delay(500).slideDown();
									}); 
								})

								$('#upload_file').val('');

								let rows 	= [],
									no_list	= 1;	
								
								$.each( data["result"]["data"], function( key, value ) {
									rows.push([
										no_list++,
										value.support_department,
										value.activity_name,
										value.activity_type,
										value.detail_activity,
										value.remarks,
										value.start_date,
										value.end_date,
										// value.duration,
										value.requestor,
										value.channel_requestor,
										// value.executor,
										value.url,
										// value.additional_info,
									])
								});

								let myTable = $('#table-list-activity').DataTable( {
									"data"		: rows,
									"autoWidth"  : false,
									"responsive": false,
									// "targets"	: [ 0 ],
									// "autoWidth"	: true,
									"retrieve": true,
									// "columnDefs": [
									// 	{ "width": "100%", "targets": 0 }
									// ],
									"bDestroy"      : true,
									// "responsive"    : true,
									"processing"    : true, //Feature control the processing indicator.
									"language"      : {
										processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
									},
									"order"         : [], //Initial no order.
									"deferRender"   : true,
									//Set column definition initialisation properties.
									"columnDefs"    : [
									{ 
										"targets": [ 0 ], //first column / numbering column
										"orderable": true, //set not orderable
									},
									],
									"lengthMenu"    : [ 10, 25, 50, 75, 100 ],
									"pageLength"    : 10,
									"initComplete": function (settings, json) {  
										$("#table-list-activity").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
									},
								});
							}else{
								Swal.fire({
									showConfirmButton: false,
									timer: 11,
								})

								location.href = "{{ url('logbook/') }}";
								// $('#modal-create-list-activity').modal('hide');
								$("#page-form-service")[0].reset();
								$('#datatable').DataTable().ajax.reload(null, false);
							}
						}
					})
				}else{
					Swal.fire({
						type    : 'error',
						html    : data['result']['message'],
						allowOutsideClick   : false,
					})
				}
			}
		})
	}

	const doImport = (e) => {
		let myTable 			= $("#table-list-activity").DataTable(),
			count				= myTable.rows().count(),
			form_data  			= myTable.rows().data(),
			link				= "{{ url('logbook/doImport') }}/"+count,
			department_name		= [],
			activity_name		= [],
			activity_type		= [],
			detail_activity		= [],
			notes				= [],
			start_date			= [],
			end_date			= [],
			requestor			= [],
			source				= [],
			executor			= [],
			url					= [],
			additional_info 	= [];

		$.each(form_data, function( keys, values ) {
			department_name.push(values[1])
			activity_name.push(values[2])
			activity_type.push(values[3])
			detail_activity.push(values[4])
			notes.push(values[5])
			start_date.push(values[6])
			end_date.push(values[7])
			requestor.push(values[8])
			source.push(values[9])
			executor.push(values[10])
			url.push(values[11])
			additional_info.push(values[12])
		});

		$.ajax({
			url: link,
			type: "POST",
			data: {
				'_token'	: "{{ csrf_token() }}",
				department_name,
				activity_name,
				activity_type,
				detail_activity,
				notes,
				start_date,
				end_date,
				requestor,
				source,
				executor,
				url,
				additional_info
			},
			beforeSend: function() {
				Swal.fire({
					title   : 'Memuat . . .',
					allowOutsideClick   : false,
					onBeforeOpen    : () => {
						Swal.showLoading()
					},
				});
			},
			success: function(data) {
				Swal.close();
				if(data['result']['status'] === "SUCCESS"){
					Swal.fire({
						type    : 'success',
						html    : data['result']['message'],
						allowOutsideClick   : false,
						}).then((result) => {
						if (result.value) {
							setTimeout(function() { 
								$('#notification').html(
								'<div class="alert alert-success" role="alert">'+
									'<h5>Result<h5>'+ 
									'<p>Data yang berhasil tersimpan '+data["result"]["c_success"]+'</p>'+
									'<p>Data yang tidak berhasil tersimpan '+data["result"]["c_failed"]+'</p>'+
								'</div>')
							}, 5000);

							location.href = "{{ url('logbook/') }}";
							// $('#modal-create-list-activity').modal('hide');
							$('#datatable').DataTable().ajax.reload(null, false);
						}
					})
				}else{
					Swal.fire({
						type    : 'error',
						html    : data['message'],
						allowOutsideClick   : false,
					})
				}
			}
		})
	}

	const viewDetail = (id) => {
		let url     		= "{{ url('logbook/get_detail_list_activity') }}/"+id,
			dataForm		= "";

		$('#modal-detail-list-activity').modal('show');
		
		$.ajax({
			url: url,
			type: "GET",
			beforeSend: function() {

			},
			success: function(response) {
				console.log(response)
				let html	= `
					<div class="row">
						<div class="col-12">
							<div class="row">
								<div class="col-5">
									<label for="input_type">Support Department Name</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.support_department.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Activity Name</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.activity.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Activity Type</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.activity_type.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Detail Activity</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.detail_activity+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Remarks</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+(response.remarks ?? "-")+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Start Date</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.start_date+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">End Date</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.end_date+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Duration</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+ (response.duration ?? "-") +`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Requestor</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.requestor.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Channel Requestor</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.channel_requestor.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">Executor</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+response.user.profile.name+`</p>
								</div>
							</div>
							<div class="row">
								<div class="col-5">
									<label for="input_type">URL</label>
								</div>
								<div class="col-sm">
									<p class="text-sm">`+(response.url ?? "-")+`</p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 mt-5 text-center">
							<button class="btn btn-sm btn-primary" onclick="exportDetail(`+response.id+`)">Export</button>
						</div>
					</div>
				`;

				$("#data-detail-list-activity").html(html)
			}
		})
	}

	const exportDetail = (id) => {
		Swal.fire({
			title   : 'Memuat . . .',
			allowOutsideClick   : false,
			timer: 1000,
			onBeforeOpen    : () => {
				Swal.showLoading()
			},
		});

		window.location	= "{{ url('logbook/doExportDetail') }}/"+id; 
	}

	window.Echo.channel('logbook').listen('LogbookEvent', (e) => {
		console.log(e)
		$('#datatable').DataTable().ajax.reload(null, false);
	});
</script>
@endif