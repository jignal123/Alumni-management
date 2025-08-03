</div>
<footer class="footer bg-dark fixed-bottom">
    <div class="container">
        <div class="row pt-3">
            <div class="col-6 text-start">
                <p class="mb-0">
                    <a href="" class="text-white">
                        <strong>Department Of computer Science Alumni</strong>
                    </a>
                </p>
            </div>
            <div class="col-6 text-end">
                <ul class="list-inline">

                    <li class="list-inline-item">
                        <a href="index.php#about" class="text-white">
                            About Us
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="magnific-popup.min.js"></script>
<script>
    AOS.init();
</script>
<script>
    const toastTrigger = document.getElementById('liveToastBtn')
    const toastLiveExample = document.getElementById('liveToast')

    if (toastTrigger) {
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
        toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
        })
    }
</script>
<script>
    $(document).ready(function () {
        $(".image").magnificPopup(
            {
                type: 'image',
                delegate: 'a',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-with-zoom', // this class is for CSS animation below

                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it

                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out'
                }
            }
        );
    });
    function submitf(form) {
    var inputcls = form.querySelectorAll(".input-field");
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
        er.innerText = msg;
        var fa = parentBox.querySelector(".fa");
        fa.className = "fa fa-exclamation-circle";
    }
    function setsuccess(f) {
        var parentBox = f.parentElement;
        parentBox.className = "input-field success";
        var er = parentBox.querySelector("span");
        er.innerText = "";
        var fa = parentBox.querySelector(".fa");
        fa.className = "fa";
    }
</script>
</body>

</html>