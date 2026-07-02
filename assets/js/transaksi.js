document.addEventListener("DOMContentLoaded", function () {

    const jumlah = document.getElementById("jumlah");
    const harga = document.getElementById("harga");
    const total = document.getElementById("total");

    const metode = document.getElementById("metode_pembayaran");

    const bayar = document.getElementById("bayar");
    const kembalian = document.getElementById("kembalian");

    const tunaiArea = document.getElementById("tunaiArea");

    const bukti = document.getElementById("bukti");
    const preview = document.getElementById("preview");

    function hitungTotal() {

        let jml = parseFloat(jumlah.value) || 0;

        let hrg = parseFloat(harga.value) || 0;

        total.value = jml * hrg;

        hitungKembalian();

    }

    function hitungKembalian() {

        let ttl = parseFloat(total.value) || 0;

        let byr = parseFloat(bayar.value) || 0;

        if (byr >= ttl) {

            kembalian.value = byr - ttl;

        } else {

            kembalian.value = 0;

        }

    }

    function cekMetode() {

        if (metode.value === "Tunai") {

            tunaiArea.style.display = "flex";

            bayar.required = true;

        } else {

            tunaiArea.style.display = "none";

            bayar.required = false;

            bayar.value = total.value;

            kembalian.value = 0;

        }

    }

    if (jumlah) {

        jumlah.addEventListener("input", hitungTotal);

    }

    if (harga) {

        harga.addEventListener("input", hitungTotal);

    }

    if (bayar) {

        bayar.addEventListener("input", hitungKembalian);

    }

    if (metode) {

        metode.addEventListener("change", cekMetode);

        cekMetode();

    }

    if (bukti) {

        bukti.addEventListener("change", function (e) {

            const file = e.target.files[0];

            if (file) {

                const reader = new FileReader();

                reader.onload = function (event) {

                    preview.src = event.target.result;

                    preview.style.display = "inline-block";

                }

                reader.readAsDataURL(file);

            } else {

                preview.style.display = "none";

            }

        });

    }

});