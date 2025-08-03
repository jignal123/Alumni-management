const aform = document.getElementById("addform");
const form = document.getElementById("myform");
$('#add').on("click", function (e) {
    checkafnm();
    checkalnm();
    checkagen();
    checkacrs();
    checkcity();
    checkayr();
    checkast();
    checkadob();
    checkaphone();
    checkapwd();
    checkacpwd();
    checkaphoto();
    checkaemail();
    afnm.addEventListener("keyup", checkafnm);
    alnm.addEventListener("keyup", checkalnm);
    agen.addEventListener("change", checkagen);
    acrs.addEventListener("change", checkacrs);
    ayr.addEventListener("change", checkayr);
    ast.addEventListener("change", checkast);
    city.addEventListener("change", checkcity);
    adob.addEventListener("change", checkadob);
    aphone.addEventListener("keyup", checkaphone);
    apwd.addEventListener("keyup", checkapwd);
    acpwd.addEventListener("keyup", checkacpwd);
    aphoto.addEventListener("change", checkaphoto);
    aemail.addEventListener("keyup", checkaemail);
    if (submitf(aform) == true) {
        // alert(submitf(aform));
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
                $("#usermodal").modal('hide');
                $('.loader').show();
                var formdata = new FormData(aform);
                $.ajax({
                    type: "POST",
                    url: "admin_backend.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $('.loader').hide();
                        //alert(data);
                        $("#addform")[0].reset();
                        $("#alumni_data").DataTable().ajax.reload();
                        if (data == 'add') {
                            // $('.loader').hide();
                            Swal.fire({
                                title: "Submitted!",
                                text: "Alumni Added Successfully",
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
                                    window.location.assign("manage_alumni.php");
                                }
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
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.assign("manage_alumni.php");
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
$('#action').on("click", function (e) {
    checkfnm();
    checklnm();
    checkgen();
    checkcrs();
    checkyr();
    checkst();
    checkdob();
    checkphone();
    checkphoto();
    checkemail();
    fnm.addEventListener("keyup", checkfnm);
    lnm.addEventListener("keyup", checklnm);
    gen.addEventListener("change", checkgen);
    crs.addEventListener("change", checkcrs);
    yr.addEventListener("change", checkyr);
    st.addEventListener("change", checkst);
    dob.addEventListener("change", checkdob);
    phone.addEventListener("keyup", checkphone);
    photo.addEventListener("change", checkphoto);
    email.addEventListener("keyup", checkemail);
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
                //$('.loader').show();
                var formdata = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: "admin_backend.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        //$('.loader').hide();
                        //alert(data);
                        $("#myform")[0].reset();
                        $("#editmodal").modal('hide');
                        $("#alumni_data").DataTable().ajax.reload();
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
                            })

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
                            })
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
var crs = document.getElementById("course");
var yr = document.getElementById("year");
var st = document.getElementById("state");
var city = document.getElementById("acity");
var dob = document.getElementById("birth");
var phone = document.getElementById("phone");
var photo = document.getElementById("photo");
var email = document.getElementById("semail");
var id = document.getElementById('user_id');
var afnm = document.getElementById("afnm");
var alnm = document.getElementById("alnm");
var agen = document.getElementById("agender");
var acrs = document.getElementById("acourse");
var ayr = document.getElementById("ayear");
var ast = document.getElementById("astate");
var adob = document.getElementById("abirth");
var aphone = document.getElementById("aphone");
var apwd = document.getElementById("apwd");
var acpwd = document.getElementById("acpwd");
var aphoto = document.getElementById("aphoto");
var aemail = document.getElementById("aemail");
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
        url: "admin_backend.php",
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
// Add Alumni Validation
function checkafnm() {
    var fvalue = afnm.value;
    var fv = /^[a-zA-Z]*$/;
    //alert(fvalue);
    if (!fv.test(fvalue)) {
        seterror(afnm, "First name should only contains alphabets no white space")
    }
    else if (fvalue == "") {
        seterror(afnm, "First name can't be blank")
    }
    else {
        setsuccess(afnm);
    }
}
function checkalnm() {
    var lvalue = alnm.value;
    var lv = /^[a-zA-Z]*$/;
    //alert(fvalue);
    if (!lv.test(lvalue)) {
        seterror(alnm, "Last name should only contains alphabets no white space")
    }
    else if (lvalue == "") {
        seterror(alnm, "Last name can't be blank");
    }
    else {
        setsuccess(alnm);
    }
}
function checkagen() {
    var gvalue = agen.value;
    if (gvalue == "") {
        seterror(agen, "Please select any gender");
    }
    else {
        setsuccess(agen);
    }
}
function checkacrs() {
    var cvalue = acrs.value;
    if (cvalue == "") {
        seterror(acrs, "Please select any Course");
    }
    else {
        setsuccess(acrs);
    }
}
function checkayr() {
    var yvalue = ayr.value;
    if (yvalue == "") {
        seterror(ayr, "Please select Starting Year");
    }
    else {
        setsuccess(ayr);
    }
}
function checkast() {
    var svalue = ast.value;
    if (svalue == "") {
        seterror(ast, "Please select State");
    }
    else {
        setsuccess(ast);
    }
}
function checkadob() {
    var d = adob.value;
    if (d == "") {
        seterror(adob, "Please Select your Date of Birth");
    }
    else {
        setsuccess(adob);
    }
}
function checkaphone() {
    var p = aphone.value;
    var pv = /^[0-9]{10,11}$/;
    if (!pv.test(p)) {
        seterror(aphone, "Phone number should be of 10 to 11 character")
    }
    else {
        setsuccess(aphone);
    }
}
function checkcity() {
    var cv = city.value;
    if (cv == "") {
        seterror(city, "It should not be blank!");
    }
    else {
        setsuccess(city);
    }
}
function checkapwd() {
    var pw = apwd.value;
    if (pw == "") {
        seterror(apwd, "It should not be blank");
    }
    else {
        setsuccess(apwd);
    }
}
function checkacpwd() {
    var cp = acpwd.value;
    if (cp !== apwd.value || cp == "") {
        seterror(acpwd, "Confirm password dosen't match");
    }
    else {
        setsuccess(acpwd);
    }
}
function checkaphoto() {
    var ph = aphoto.value;
    var phv = /[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
    if (!phv.test(ph)) {
        seterror(aphoto, "It should be in jpg,jpeg,png or gif Form");
    }
    else if(ph!= "") {
        var file = aphoto.files[0].size;
        var kbsize = (file / 1024);
        //alert(kbsize);
        if (kbsize > 300) {
            seterror(aphoto, "File size should be less than 300KB");
        }
        else {
            setsuccess(aphoto);
        }
    }
}
function checkaemail() {
    var e = aemail.value;
    var ev = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    $.ajax({
        type: "post",
        url: "admin_backend.php",
        data: { asemail: e },
        success: function (response) {
            if (!ev.test(e)) {
                seterror(aemail, "Invalid Email Format");
            }
            else if (response > 0) {
                seterror(aemail, "Email Alredy Exists Try Diffrent One")
            }
            else {
                setsuccess(aemail);
            }
        }
    });
}