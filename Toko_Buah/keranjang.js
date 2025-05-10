document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        // Tombol tambah
        if (e.target.classList.contains('btn-tambah')) {
            const id = e.target.dataset.id;
            const stok = parseInt(e.target.dataset.stok);
            const input = document.querySelector(`.jumlah-input[data-id="${id}"]`);
            const hidden = document.querySelector(`.jumlah-keranjang[data-id="${id}"]`);
            let jumlah = parseInt(input.value);

            if (jumlah < stok) {
                jumlah += 1;
                input.value = jumlah;
                if (hidden) hidden.value = jumlah;
            }
        }

        // Tombol kurang
        if (e.target.classList.contains('btn-kurang')) {
            const id = e.target.dataset.id;
            const input = document.querySelector(`.jumlah-input[data-id="${id}"]`);
            const hidden = document.querySelector(`.jumlah-keranjang[data-id="${id}"]`);
            let jumlah = parseInt(input.value);

            if (jumlah > 0) {
                jumlah -= 1;
                input.value = jumlah;
                if (hidden) hidden.value = jumlah;
            }
        }

        // Saat klik tombol keranjang, sinkronkan jumlah
        if (e.target.closest('.btn-keranjang')) {
            const btn = e.target.closest('.btn-keranjang');
            const form = btn.closest('form');
            const id = form.querySelector('input[name="id"]').value;
            const input = document.querySelector(`.jumlah-input[data-id="${id}"]`);
            const jumlah = input ? parseInt(input.value) : 0;
            const hidden = form.querySelector('.jumlah-keranjang');

            if (hidden) hidden.value = jumlah;

            // Cegah submit jika 0
            if (jumlah <= 0) {
                e.preventDefault();
                alert('Jumlah harus minimal 1 untuk ditambahkan ke keranjang.');
            }
        }

        // Tombol "Pesan" juga dicegah kalau jumlah 0
        if (e.target.closest('button[name="pesan"]')) {
            const form = e.target.closest('form');
            const id = form.querySelector('input[name="id"]').value;
            const input = document.querySelector(`.jumlah-input[data-id="${id}"]`);
            const jumlah = input ? parseInt(input.value) : 0;
            const hidden = form.querySelector('input[name="jumlah"]');

            if (hidden) hidden.value = jumlah;

            if (jumlah <= 0) {
                e.preventDefault();
                alert('Silakan tambahkan jumlah terlebih dahulu.');
            }
        }
    });
});
