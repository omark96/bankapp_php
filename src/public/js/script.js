document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('updateCsrf', function (e) {
        const token = e.detail.value;

        document.querySelectorAll('input[name="csrf_token"]').forEach(input => {
            input.value = token;
        });
    });
});