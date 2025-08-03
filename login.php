<!doctype html>
<html lang="en">

<head>
    <?php session_start();
    if (
        isset($_SESSION['admin'])

    ) {
        header("Location: admin/index.php");
    }
    if (
        isset($_SESSION['alumni'])
    ) {
        header("Location: student/index.php");
    }
    if (isset($_POST['email']) && isset($_POST["pwd"])) {
        include ("dbconfig.php");
        $form = filter($_POST);
        extract($form);
        $q = "SELECT * FROM user_master WHERE email=? AND password=?";
        $array = array($email, md5($pwd));
        $ans = query($q, $array);
        if ($ans->rowCount() && $ans->rowCount() == 1) {
            $login = $ans->fetch();
            if ($login['role_id'] == "1") {
                $_SESSION["admin"] = $login["email"];
                $_SESSION['image'] = $login['image'];
                header("Location: admin/index.php");
            } else {
                $_SESSION["alumni"] = $login["email"];
                $_SESSION['student_id'] = $login['user_id'];
                $_SESSION['spass'] = $login['password'];
                $_SESSION['sname'] = $login['first_name'];
                $_SESSION['ssurname'] = $login['last_name'];
                $_SESSION['sdob'] = $login['dob'];
                $_SESSION['status'] = $login['status'];
                $_SESSION['saddress'] = $login['address'];
                $_SESSION['course_id'] = $login['course_id'];
                $_SESSION['start_year'] = $login['start_year'];
                $_SESSION['duration_id'] = $login['duration_id'];
                $_SESSION['profession'] = $login['profession'];
                $_SESSION['sstate'] = $login['u_state'];
                $_SESSION['scity'] = $login['u_city'];
                $_SESSION['sphone'] = $login['phone'];
                $_SESSION['sgender'] = $login['gender'];
                $_SESSION['srole_id'] = $login['role_id'];
                $_SESSION['simage'] = $login['image'];
                header("Location: student/index.php");
            }
        } else {
            $alert = ' <script>
            Swal.fire({
                title: "Error In Login",
                text: "Please Check your password and username",
                icon: "error"
            });
        </script>'
                ?>

            <?php
        }
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./admin/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navi">
        <nav class="d-flex pt-2 pb-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-1">
                    <img src="./admin/logo.jpg" alt="" class="pb-1" style="height: 50px;">
                    </div>
                    <div class="col-4">
                        <h1 class="pt-1">Alumni Portal</h1>
                    </div>
                    <div class="nav col-7 justify-content-end">
                        <ul class="d-flex flex-row pt-2">
                            <li><a href="" class="active me-3" style="color:aliceblue;">Login</a></li>
                            <li><a href="register.php" class="">signup</a></li>
                            <li><a href="events.php">Events</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="regtr">
        <div class="container col-lg-3 col-sm-6">
            <div class="row mt-5">
                <div class="col-md-12 d-flex justify-content-center al">
                    <div class="title mt-3 mb-2">
                        <h2><i class="fa fa-user-o me-1" aria-hidden="true"></i>Login</h2>
                    </div>
                </div>
            </div>
            <form action="" name="myform" method="post" class="row mt-1 p-2">
                <div class="col-12">
                    <label for="email" class="form-label"><i class="fa fa-user me-1"
                            aria-hidden="true"></i>Username</label>
                    <div class="input-field">
                        <input type="text" name="email" id="email" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <label for="pwd" class="form-label"><i class="fa fa-lock me-1"
                            aria-hidden="true"></i>Password</label>
                    <div class="input-field">
                        <input type="password" name="pwd" id="pwd" class="form-control">
                        <i class="fa" aria-hidden="true"></i>
                        <span class="d-flex">
                        </span>
                    </div>
                </div>
                <div class="col-md-12" align="center">
                    <input type="submit" value="Login" class="active mt-3 mb-3" name="login" id="login">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script>
        const form = document.querySelector("form");
        const submitfrm = document.getElementById("login");
        submitfrm.addEventListener("click", function (e) {
            e.preventDefault();
            checkpwd();
            checkemail();
            pwd.addEventListener("keyup", checkpwd);
            email.addEventListener("keyup", checkemail);
            if (submitf() == true) {
                form.submit();
            } else {
                e.preventDefault();
            }
        });
        var pwd = document.getElementById("pwd");
        var email = document.getElementById("email");

        function submitf() {
            var inputcls = form.querySelectorAll(".input-field");
            var result = true;
            inputcls.forEach((a) => {
                if (a.classList.contains("error")) {
                    result = false;
                }
            });
            return result;
        }

        function checkpwd() {
            var pw = pwd.value;
            if (pw == "") {
                seterror(pwd, "It should not be blank");
            } else {
                setsuccess(pwd);
            }
        }

        function checkemail() {
            var e = email.value;
            var ev = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(!ev.test(e)){
                seterror(email,"Email Format is Incorrect");
            }else{
                setsuccess(email);
            }
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
    <?php
    if (isset($alert)) {
        echo $alert;
        $alert = "";
    }
    ?>

</body>

</html>