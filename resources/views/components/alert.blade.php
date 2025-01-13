@if (session()->has($type))
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        {{ session($type) }}
    </div>
@endif


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // Wait for the document to be ready
    $(document).ready(function () {
        // Find the alert with the fade class
        var alert = $('.alert-dismissible.fade');

        // Check if the alert exists
        if (alert.length > 0) {
            // Set a timeout to hide the alert after 3000 milliseconds (3 seconds)
            setTimeout(function () {
                alert.alert('close');
            }, 3000);
        }
    });
</script>
