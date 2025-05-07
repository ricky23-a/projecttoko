document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const buahContainer = document.getElementById('buah-container');

    function loadBuah(keyword = '') {
        fetch(`load_buah.php?search=${encodeURIComponent(keyword)}`)
            .then(response => response.text())
            .then(html => {
                buahContainer.innerHTML = html;
            });
    }

    // Load semua data pertama kali
    loadBuah();

    // Cegah submit form (misalnya Enter ditekan)
    searchInput.form.addEventListener('submit', function (e) {
        e.preventDefault();
    });

    // AJAX saat input diketik/diubah
    searchInput.addEventListener('input', function () {
        loadBuah(this.value);
    });
});
