<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.date-input').forEach(function(input) {
        flatpickr(input, {
            dateFormat: 'd/m/Y',
            allowInput: true,
            disableMobile: true,
        });
    });
});
</script>
