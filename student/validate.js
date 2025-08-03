const form = document.getElementById("myform");
$('#sub').on("click", function (e) {
    e.preventDefault();
    checkfnm();
    checklnm();
    checkgen();
    checkst();
    checkdob();
    checkphone();
    checkphoto();
    checkemail();
    fnm.addEventListener("keyup", checkfnm);
    lnm.addEventListener("keyup", checklnm);
    gen.addEventListener("change", checkgen);
    st.addEventListener("change", checkst);
    dob.addEventListener("change", checkdob);
    phone.addEventListener("keyup", checkphone);
    photo.addEventListener("change", checkphoto);
    if (submitf(form) == true) {
        e.preventDefault();
        Swal.fire({
            title: "Are you sure to Save Changes?",
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
                var formdata = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: "user_backend.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('.loader').hide();
                        //alert(data);
                        if (data == 'edit') {
                            // $('.loader').hide();
                            Swal.fire({
                                title: "Edited!",
                                text: "Alumni Edited Successfully",
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
                            }).then((result) =>{
                                window.location.assign("profile.php");
                            });

                        } else {
                            // $('.loader').hide();
                            Swal.fire({
                                title: "Error!",
                                text: data,
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
                            }).then((result) =>{
                                window.location.assign("profile.php");
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

var fnm = document.getElementById("fnm");
var lnm = document.getElementById("lnm");
var gen = document.getElementById("gender");
var st = document.getElementById("state");
var city = document.getElementById("acity");
var dob = document.getElementById("birth");
var phone = document.getElementById("phone");
var photo = document.getElementById("photo");
var email = document.getElementById("semail");
var id = document.getElementById('user_id');
email.addEventListener("keyup", checkemail);
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
function checkst() {
    var svalue = st.value;
    if (svalue == "") {
        seterror(st, "Please select State");
    }
    else {
        setsuccess(st);
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
function checkphoto() {
    var ph = photo.value;
    var phv = /[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
    if (ph != "" && !phv.test(ph)) {
        seterror(photo, "It should be in jpg,jpeg,png or gif Form");
    }
    else if(ph!= "") {
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
    var uid = id.value;
    var ev = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    $.ajax({
        type: "post",
        url: "../admin/admin_backend.php",
        data: { email: e, id: uid },
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

