    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const tombolDelete = document.querySelectorAll(".btn-delete");

    tombolDelete.forEach(function(btn){

        btn.addEventListener("click", function(e){

            e.preventDefault();

            const url = this.getAttribute("href");

            Swal.fire({

                title: "Hapus transaksi?",

                text: "Data yang sudah dihapus tidak dapat dikembalikan.",

                icon: "warning",

                showCancelButton: true,

                confirmButtonColor: "#ff5c96",

                cancelButtonColor: "#6c757d",

                confirmButtonText: "Ya, Hapus",

                cancelButtonText: "Batal"

            }).then((result)=>{

                if(result.isConfirmed){

                    window.location.href = url;

                }

            });

        });

    });

});

</script>