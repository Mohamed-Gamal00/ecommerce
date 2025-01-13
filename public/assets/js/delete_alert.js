function confirmDelete() {
    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'لن يمكنك التراجع عن هذا الإجراء!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم، قم بالحذف!',
        cancelButtonText: 'لا، ألغِ الأمر'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, submit the form
            document.forms["yourFormId"].submit();
        }
    });
}
