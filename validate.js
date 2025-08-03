const form = document.getElementById("myform");
$('#myform').on("submit", function (e) {
    e.preventDefault();
    checkfnm();
    checklnm();
    checkgen();
    checkcrs();
    checkyr();
    checkct();
    checkst();
    checkdob();
    checkphone();
    checkpwd();
    checkcpwd();
    checkphoto();
    checkemail();
    fnm.addEventListener("keyup", checkfnm);
    lnm.addEventListener("keyup", checklnm);
    gen.addEventListener("change", checkgen);
    crs.addEventListener("change", checkcrs);
    yr.addEventListener("change", checkyr);
    st.addEventListener("change", checkst);
    ct.addEventListener("change", checkct);
    dob.addEventListener("change", checkdob);
    phone.addEventListener("keyup", checkphone);
    pwd.addEventListener("keyup", checkpwd);
    cpwd.addEventListener("keyup", checkcpwd);
    photo.addEventListener("change", checkphoto);
    email.addEventListener("keyup", checkemail);
    if (submitf() == true) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure to submit?",
            icon: "warning",
            showClass: {
                popup: `
                animate__animated
                animate__fadeInDown
                animate__faster
              `
            },
            hideClass: {
                popup: `
                 animate__animated
                 animate__fadeOutUp
                 animate__faster
               `
            },
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('.loader').show();
                var formdata = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "registration_backend.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data == 'reg') {
                            $('.loader').hide();
                            Swal.fire({
                                title: "Submitted!",
                                text: "Registered Successfully",
                                icon: "success",
                                showClass: {
                                    popup: `
                                animate__animated
                                animate__fadeInDown
                                animate__faster
                              `
                                },
                                hideClass: {
                                    popup: `
                                 animate__animated
                                 animate__fadeOutUp
                                 animate__faster
                               `
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.assign("register.php");
                                }
                            });

                        } else {
                            $('.loader').hide();
                            Swal.fire({
                                title: "Error!",
                                text: "Some error occurred",
                                icon: "error",
                                showClass: {
                                    popup: `
                                animate__animated
                                animate__fadeInDown
                                animate__faster
                              `
                                },
                                hideClass: {
                                    popup: `
                                 animate__animated
                                 animate__fadeOutUp
                                 animate__faster
                               `
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.assign("register.php");
                                }
                            });
                        }
                    }
                });
            }
        });
    }
    else {
        e.preventDefault();
    }
});
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
var fnm = document.getElementById("fnm");
var lnm = document.getElementById("lnm");
var gen = document.getElementById("gender");
var crs = document.getElementById("course");
var yr = document.getElementById("year");
var st = document.getElementById("state");
var ct = document.getElementById("city");
var dob = document.getElementById("birth");
var phone = document.getElementById("phone");
var pwd = document.getElementById("pwd");
var cpwd = document.getElementById("cpwd");
var photo = document.getElementById("photo");
var email = document.getElementById("semail");
function checkfnm() {
    var fvalue = fnm.value;
    var fv = /^[a-zA-Z]*$/;
    //alert(fvalue);
    if (!fv.test(fvalue)) {
        seterror(fnm, "First name should only contains alphabets no white space")
    }
    else if (fvalue == "") {
        seterror(fnm, "First name can't be blank")
    }
    else {
        setsuccess(fnm);
    }
}
function checklnm() {
    var lvalue = lnm.value;
    var lv = /^[a-zA-Z]*$/;
    //alert(fvalue);
    if (!lv.test(lvalue)) {
        seterror(lnm, "Last name should only contains alphabets no white space")
    }
    else if (lvalue == "") {
        seterror(lnm, "Last name can't be blank");
    }
    else {
        setsuccess(lnm);
    }
}
function checkgen() {
    var gvalue = gen.value;
    if (gvalue == "") {
        seterror(gen, "Please select any gender");
    }
    else {
        setsuccess(gen);
    }
}
function checkcrs() {
    var cvalue = crs.value;
    if (cvalue == "") {
        seterror(crs, "Please select any Course");
    }
    else {
        setsuccess(crs);
    }
}
function checkyr() {
    var yvalue = yr.value;
    if (yvalue == "") {
        seterror(yr, "Please select Starting Year");
    }
    else {
        setsuccess(yr);
    }
}
function checkst() {
    var svalue = st.value;
    if (svalue == "") {
        seterror(st, "Please select State");
    }
    else {
        setsuccess(st);
    }
}
function checkct() {
    var cvalue = ct.value;
    if (cvalue == "") {
        seterror(ct, "Please select City");
    }
    else {
        setsuccess(ct);
    }
}
function checkdob() {
    var d = dob.value;
    if (d == "") {
        seterror(dob, "Please Select your Date of Birth");
    }
    else {
        setsuccess(dob);
    }
}
function checkphone() {
    var p = phone.value;
    var pv = /^[0-9]{10,11}$/;
    if (!pv.test(p)) {
        seterror(phone, "Phone number should be of 10 to 11 character")
    }
    else {
        setsuccess(phone);
    }
}
function checkpwd() {
    var pw = pwd.value;
    if (pw == "") {
        seterror(pwd, "It should not be blank");
    }
    else {
        setsuccess(pwd);
    }
}
function checkcpwd() {
    var cp = cpwd.value;
    if (cp !== pwd.value || cp == "") {
        seterror(cpwd, "Confirm password dosen't match");
    }
    else {
        setsuccess(cpwd);
    }
}
function checkphoto() {
    var ph = photo.value;
    var phv = /[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
    if (!phv.test(ph)) {
        seterror(photo, "It should be in jpg,jpeg,png or gif Form");
    }
    else if(ph != "") {
        var file = photo.files[0].size;
        var kbsize = (file/1024);
        //alert(kbsize);
        if(kbsize > 300){
            seterror(photo, "File size should be less than 300KB");
        }
        else{
            setsuccess(photo);
        }
    }
}
function checkemail() {
    var e = email.value;
    var ev = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    $.ajax({
        type: "post",
        url: "registration_backend.php",
        data: { email: e },
        success: function (response) {
            if (!ev.test(e)) {
                seterror(email, "Invalid Email Format");
            }
            else if (response > 0) {
                seterror(email, "Email Alredy Exists Try Diffrent One")
            }
            else {
                setsuccess(email);
            }
        }
    });
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