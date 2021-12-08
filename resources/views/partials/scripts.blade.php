<!-- overlayScrollbars -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-3.1.0/dist/js/adminlte.js') }}"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>

<script src="{{ asset('AdminLTE-3.1.0/plugins/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.1.0/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<script type="application/javascript">
    $(function(){
        @php
            $url = explode('/', url()->current());
            $base_url = $url[0].'//'.$url[2].'/'.($url[3] ?? '').(isset($url[4]) ? '/'.$url[4] : '');
        @endphp
        var url = '{{ $base_url }}';
        var controller = '{{ $url[3] }}';
        // for sidebar menu but not for treeview submenu
        $('ul.nav-sidebar li a').filter(function() {
            if(url == $(this).attr('href')){
                $(this).addClass('active')
            }
        })
        $('ul.nav-treeview li a').filter(function() {
            if(url == $(this).attr('href')){
                $(this).parent().parent().parent().addClass('menu-open')
                $(this).parent().parent().parent().find('a[href="#"]').addClass('active')
            }
        })
    })
</script>
<!-- Bootstrap -->
<script src="{{ asset('AdminLTE-3.1.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script>
    // loader
    $(window).on('beforeunload', function(){
       $('#loader').fadeIn();
    });
    $(window).on('load', function(){
       $('#loader').fadeOut();
    });

    // for select2 inside the modal
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // table row link
    $('tr[data-toggle="modal-ajax"]').css('cursor', 'pointer')
    $(function() {
        $(".tr-link").click(function() {
            window.location = $(this).data("href");
        });
        $(document).on('click', 'tr[data-toggle="tr-link"]', function(){
            window.location = $(this).data("href");
        })
    });

    function deleteFromTable(button){
        var href = $(button).data('href');
        $('#deleteLink').attr('action', href);
        $('#deleteFromTableModal').modal('show');
    }

    $(document).on('click', '.modal-delete-close', function(){
        $('#deleteLink').attr('action', '');
        $('#deleteFromTableModal').modal('hide');
    })

    function restoreFromTable(button){
        var href = $(button).data('href');
        $('#restoreLink').attr('action', href);
        $('#restoreFromTableModal').modal('show');
    }

    $(document).on('click', '.modal-restore-close', function(){
        $('#restoreLink').attr('action', '');
        $('#restoreFromTableModal').modal('hide');
    })

    function ajax_error(xhr, ajaxOptions, thrownError){
        if(xhr.responseJSON.exception == "Spatie\\Permission\\Exceptions\\UnauthorizedException"){
            ajax_permission_denied();
        }else{
            $('#ajaxOptions').html(ajaxOptions);
            $('#thrownError').html(thrownError);
            $('#xhr').html(xhr.responseJSON.message);
            $('#modalAjaxError').modal('show');
        }
    }

    function ajax_permission_denied(){
        Swal.fire({
            type: 'error',
            title: "Access Denied",
            text: "User does not have the right permissions.",
        })
    }

    function removeLocationHash(){
        var noHashURL = window.location.href.replace(/#.*$/, '');
        window.history.replaceState('', document.title, noHashURL)
    }

    // Modal Ajax
    $(document).on('click', '[data-toggle="modal-ajax"]', function(){
        $('#loader').show();
        var href = $(this).data('href');
        var target = $(this).data('target');
        var data = {};
        if($(this).data('form') != null){
            var form = $(this).data('form').split(';');
            for (var i = 0; i < form.length; i++) {
                var form_data = form[i].split(':');
                for(var j = 1; j < form_data.length; j++){
                    data[form_data[j-1]] = form_data[j];
                }
            }
        }
        $.ajax({
            type: 'GET',
            url: href,
            data: data,
            success: function(data){
                // $('.modal-backdrop').remove()
                $('#modalAjax').html(data.modal_content)
                $('.select2').select2({
                    theme: "bootstrap4",
                    placeholder: "Select",
                    // allowClear: true
                });
                $('.datetimepicker').datetimepicker();
                $('#oldInput').find('input').each(function(){
                    var name = $(this).attr('name').replace('old_', '');
                    if(name != '_token'){
                        var value = $(this).val();
                        $('#modalAjax [name="'+name+'"]').parent('.form-group').find('.invalid-feedback').html('<strong class="text-danger">'+$(this).data('error-message')+'</strong>')
                        $('#modalAjax').find('input[type="text"][name="'+name+'"]').val(value).addClass($(this).data('error'));
                        $('#modalAjax').find('input[type="checkbox"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                        $('#modalAjax').find('input[type="radio"][name="'+name+'"][value="'+value+'"]').prop('checked', true);
                        $('#modalAjax').find('select[name="'+name+'"]').val(value).trigger('change').addClass($(this).data('error'));
                    }
                })
                $(target).modal('show')
                $('#loader').hide();
                
            },
            error: function(xhr, ajaxOptions, thrownError){
                ajax_error(xhr, ajaxOptions, thrownError)
                // removeLocationHash()
                $('#loader').hide();
            }
        })
    })

    $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
        // closeAllModals()
        $('.modal').modal('hide')
        $('.modal-backdrop').fadeOut(250, function() {
            $('.modal-backdrop').remove()
        })
        $('body').removeClass('modal-open').css('padding-right', '0px');
        $('#oldInput').html('');
        $('#modalAjax').html('')
        removeLocationHash()
    })

    $(function(){
        $('.toast').toast('show')

        $('[data-toggle="popover"').popover()
        $('[data-toggle="popover-sanitize"]').popover({
            html: true,
            sanitize: false,
            container: 'body',
        })
	})

</script>

{{-- Set current sidebar active link --}}
<script type="application/javascript">
    $(function(){
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        $('.nav-tabs a').click(function (e) {
            $(this).tab('show');
            window.location.hash = this.hash;
        });
    });
</script>

{{-- Backdrop for double modal --}}
<script type="application/javascript">
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
</script>

{{-- Disable Submit Button --}}
<script type="application/javascript">
    $(function() {
        $(document).on('submit', 'form', function(){
            $(this).find('button[type=submit]').prop('disabled', true).append(' <i class="fa fa-spinner fa-spin fa-pulse"></i>')
        })
    });
</script>

{{-- Initialize tempusdominus-bootstrap --}}
<script type="application/javascript">
    $.extend(true, $.fn.datetimepicker.Constructor.Default, {
        icons: {
            /* time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'fas fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'far fa-times-circle' */
            time: 'far fa-clock',
            date: 'far fa-calendar-alt',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'far fa-trash-alt',
            close: 'fas fa-times'
        },
        buttons: {
            showToday: true,
            showClose: true,
            showClear: true
        }
    });

    // Initialize
    $('.datetimepicker').datetimepicker();
    $('.datetimepicker-no-time').datetimepicker({
        buttons: {
            time: false,
        }
    });
</script>

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

{{--  Action Alert --}}
<script type="application/javascript">
    @if($message = Session::get('alert-success'))
        Swal.fire({
			// position: 'top-end',
			type: 'success',
			title: '{{ $message }}',
			showConfirmButton: false,
			timer: 2000,
			toast: true
		})
    @elseif($message = Session::get('alert-warning'))
        Swal.fire({
			// position: 'top-end',
			type: 'warning',
			title: '{{ $message }}',
			showConfirmButton: false,
			timer: 2000,
			toast: true
		})
    @elseif($message = Session::get('alert-danger'))
        Swal.fire({
			// position: 'top-end',
			type: 'success',
			title: '{{ $message }}',
			showConfirmButton: false,
			timer: 2000,
			toast: true
		})
    @endif

    // Close action alert
    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".action-alert").alert('close');
        }, 2000);
	});

	function ajaxActionAlert(type, message) {
		switch (type) {
			case 'success':
				Swal.fire({
					// position: 'top-end',
					type: 'success',
					title: message,
					showConfirmButton: false,
					timer: 2000,
					toast: true
				})
				break;
			case 'warning':
				Swal.fire({
					// position: 'top-end',
					type: 'warning',
					title: message,
					showConfirmButton: false,
					timer: 2000,
					toast: true
				})
				break;
			case 'danger':
				Swal.fire({
					// position: 'top-end',
					type: 'danger',
					title: message,
					showConfirmButton: false,
					timer: 2000,
					toast: true
				})
				break;
			default:
				break;
		}

	}
</script>

{{-- Initialize DataTable --}}
<script type="application/javascript">
    $(document).ready( function () {
        $('#datatable').DataTable();
        $('.datatable').DataTable();
    });
</script>

{{-- Initialize Colorpicker --}}
<script>
    $('.partylist-color').colorpicker()
    $('.partylist-color').on('colorpickerChange', function(event) {
        $('.partylist-color .fa-square').css('color', event.color.toString());
    })
</script>