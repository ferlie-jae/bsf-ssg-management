<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>
		<!-- jQuery -->
		<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery/jquery.min.js') }}"></script>
		
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/dist/css/adminlte.min.css') }}">
		
		<link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE-3.1.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    </head>
    <body class="hold-transition login-page mt-5">
		{{-- <div class="row justify-content-center">
			<div class="col-md-6"> --}}
				<div class="card card-outline card-primary mt-5">
					<div class="card-header">
						<a href="/" class="h1">Binmaley School of Fisheries Management</a>
					</div>
					<form action="{{ route('student_registration.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="card-body">
							<p class="login-box-msg">Please fill up all required(<strong class="text-danger">*</strong>) information.</p>
							<div class="form-group row">
								<div class="col-sm-4">
									<label>School ID <strong class="text-danger">*</strong></label>
								</div>
								<div class="col-sm-8">
									{{-- <div class="input-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="exampleInputFile" name="school_id" accept="image/*">
											<label class="custom-file-label" for="exampleInputFile">Choose file</label>
										</div>
									</div> --}}
									<input type="file" name="school_id" accept="image/png, image/jpeg, image/jpg" required><br>
									<i>upload a clear photo of your School ID for validation</i>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputStudentID" class="col-sm-4 col-form-label">Student ID <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="text" name="student_id" class="form-control @error('student_id') is-invalid @enderror" id="inputStudentID" placeholder="Student ID" value="{{ old('student_id') }}" required>
									@error('student_id')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="inputYearLevel" class="col-sm-4 col-form-label">Grade/Section <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<select class="form-control select2" name="section">
										<option></option>
										@foreach ($sections as $section)
											<option value="{{ $section->id }}" @if(old('section') == $section->id) selected @endif >
												Grade {{ $section->grade_level }}
												{{ $section->name }}
											</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputFirstName" class="col-sm-4 col-form-label">First Name <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="text" name="first_name" class="form-control" id="inputFirstName" placeholder="First Name" value="{{ old('first_name') }}" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputMiddleName" class="col-sm-4 col-form-label">Middle Name</label>
								<div class="col-sm-8">
									<input type="text" name="middle_name" class="form-control" id="inputMiddleName" placeholder="Middle Name" value="{{ old('middle_name') }}">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputLastName" class="col-sm-4 col-form-label">Last Name <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="text" name="last_name" class="form-control" id="inputLastName" placeholder="Last Name" value="{{ old('last_name') }}" required>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputSuffix" class="col-sm-4 col-form-label">Suffix</label>
								<div class="col-sm-8">
									<input type="text" name="suffix" class="form-control" id="inputSuffix" placeholder="Suffix" value="{{ old('suffix') }}">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Gender <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<div class="custom-control custom-radio">
										<input class="custom-control-input" name="gender" type="radio" id="genderMale" value="male" @if(old('gender') == 'male') checked @endif>
										<label for="genderMale" class="custom-control-label">Male</label>
									</div>
									<div class="custom-control custom-radio">
										<input class="custom-control-input" name="gender" type="radio" id="genderFemale" value="female" @if(old('gender') == 'female') checked @endif>
										<label for="genderFemale" class="custom-control-label">Female</label>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label for="inputBirthDate" class="col-sm-4 col-form-label">Birth Date <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input id="birthDate" onchange="calculateAge(this)" class="form-control" type="date" name="birth_date" value="{{ old('birth_date') }}" required>
									<span id="age"></span>
									<span class="invalid-feedback" role="alert">
										<strong>Age must be 6 years old and above.</strong>
									</span>
								</div>
							</div>
							<hr>
							<div class="form-group row">
								<label for="inputEmail" class="col-sm-4 col-form-label">Email <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="inputEmail" placeholder="Email" value="{{ old('email') }}">
									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							{{-- <div class="form-group row">
								<label for="inputPassword" class="col-sm-4 col-form-label">Password <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputPasswordConfirmation" class="col-sm-4 col-form-label">Confirm Password <strong class="text-danger">*</strong></label>
								<div class="col-sm-8">
									<input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation" placeholder="Confirm Password">
								</div>
							</div> --}}
						</div>
						<div class="card-footer text-right">
							<button type="submit" class="btn btn-info">Register</button>
							{{-- <button type="submit" class="btn btn-default float-right">Cancel</button> --}}
						</div>
					</form>
				</div>
			{{-- </div>
		</div> --}}
		<script src="{{ asset('AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js') }}"></script>
		{{-- Initilize select2 --}}
		<script type="application/javascript">
			$(function() {
				$.fn.select2.defaults.set('theme', 'bootstrap4');
				$('.select2').select2({
					theme: "bootstrap4",
					placeholder: "Select",
				});
				
				$('.select2-allow-clear').select2({
					theme: "bootstrap4",
					placeholder: "Select",
					allowClear: true
				});

				$('.select2-tag').select2({
					theme: "bootstrap4",
					placeholder: "Select",
					allowClear: true,
					tags: true,
				});
				
			});
		</script>
		<script>
			function calculateAge(input){
				var dob = $(input).val();
				dob = new Date(dob);
				var today = new Date();
				var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
				if(age < 6){
					$('#btnSubmit').prop('disabled', true)
					$(input).addClass('is-invalid');
				}else{
					$('#btnSubmit').prop('disabled', false)
					$(input).removeClass('is-invalid');
				}
				if(age > -1){
					$('#age').html(age+' years old');
				}else{
					$('#age').html('0 years old');
				}
			}
			$(function(){
				addUserCredentials()
		
				$('#addUserAccount').on('change', function(){
					addUserCredentials()
				})
		
				function addUserCredentials(){
					if($('#addUserAccount').prop('checked')){
						$('#userCredentials input').attr('disabled', false)
						$('#userCredentials select').attr('disabled', false)
					}else{
						$('#userCredentials input').attr('disabled', true)
						$('#userCredentials select').attr('disabled', true)
					}
				}
				
			})
		</script>
    </body>
</html>