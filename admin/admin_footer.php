</main>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script> -->
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
<script src="admin_script.js"></script>
<script>
    function submitf(f) {
        var inputcls = f.querySelectorAll(".input-field");
        var result = true;
        inputcls.forEach((a) => {
            if (a.classList.contains("error")) {
                result = false;
            }
        });
        return result;
    }
    function seterror(f, msg) {
        var parentBox = f.parentElement;
        parentBox.className = "input-field error";
        var er = parentBox.querySelector("span");
        er.innerHTML = msg;
        var fa = parentBox.querySelector(".fa");
        fa.className = "fa fa-exclamation-circle";
    }
    function setsuccess(f) {
        var parentBox = f.parentElement;
        parentBox.className = "input-field success";
        var er = parentBox.querySelector("span");
        er.innerHTML = "";
        var fa = parentBox.querySelector(".fa");
        fa.className = "fa";
    }
</script>
</body>

</html>