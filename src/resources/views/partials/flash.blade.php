
@if (session()->has('flash_message'))
    <script>
        swal({
            title: "{{ session('flash_message.title') }}",
            text: "{{ session('flash_message.message') }}",
            type: "{{ session('flash_message.level') }}",
            timer: 2500,
            showConfirmButton: false,
            allowEscapeKey: true,
            allowOutsideClick: true
        },
            function() {
                location.reload(true);
            });
    </script>
@endif

@if (session()->has('flash_message_overlay'))
    <script>
        swal({
            title: "{{ session('flash_message_overlay.title') }}",
            text: "{{ session('flash_message_overlay.message') }}",
            type: "{{ session('flash_message_overlay.level') }}",
            confirmButtonText: 'Okay'
        });
    </script>
@endif

@if (session()->has('flash_message_custom_error_overlay'))
    <script>
        swal({
            title: "{{ session('flash_message_custom_error_overlay.title') }}",
            text: "{{ session('flash_message_custom_error_overlay.message') }}",
            type: "{{ session('flash_message_custom_error_overlay.level') }}",
            //timer: 5000,
            confirmButtonText: 'Okay',
            allowEscapeKey: true,
            allowOutsideClick: true
        });
    </script>
@endif