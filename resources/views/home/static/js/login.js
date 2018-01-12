(function(){
    var data = {};
    //给“下一步”按钮绑定点击事件
    $('.step1').on('click','.btn-next',function(){
        var doctor_mobile = $("#doctor_mobile").val();
        var password = $("#password").val();
        var repassword = $("#repassword").val();
        var sureCheck =$("#sureCheck").val();
        if(doctor_mobile ==''){
            modelAlert('请输入手机号!');
            return false;
        }
        if(!/^1[35789]\d{9}$/.test(doctor_mobile)){
            modelAlert('请检查手机号是否正确');
            return false;
        }

        if(password =='' || password.length <6){
            modelAlert('请输入长度大于6位的密码!');
            return false;
        }
        if(password !== repassword){
//            $("#password").next().text('请输入6位数以上密码!');
            modelAlert('两次密码不相同');
            return false;
        }
        if(!sureCheck){
            modelAlert('请确认同意协议');
            return false;
        }
        $.ajax({
            type: 'post',
            url: 'index/ajax',
            data: {
                'action': 'checkPhoneExist',
                'doctor_mobile':doctor_mobile,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function (XMLHttpRequest) {
            },
            success: function (json) {
                if (json.status == 1) {
                    data.doctor_mobile = doctor_mobile;
                    data.password = password;
                    console.log(data)
                    $('.step1').hide();
                    $('.step2').show();
                } else {
                    modelAlert(json.msg);
                }
            },
            complete: function () {
            },
            error: function () {
                modelAlert("服务器繁忙！");
            }
        });

    })

    $('.step2').on('click','.btn-next',function(){
        var doctor_name = $("#doctor_name").val();
        var id_card = $("#id_card").val();
        var province10 = $("#province10").val();
        var city10 = $("#city10").val();
        var district10 = $("#district10").val();

        var hospital_name = $("#hospital_name").val();
        var bank_card_no = $("#bank_card_no").val();
        var bank_name = $("#bank_name").val();
        if(doctor_name ==''){
            modelAlert('请输入姓名!');
            return false;
        }
        if(id_card ==''){
            modelAlert('请输入身份证件号!');
            return false;
        }
        if(province10 ==''){
            modelAlert('请选择省!');
            return false;
        }
        if(city10 ==''){
            modelAlert('请选择市!');
            return false;
        }
        /*if(district10 ==''){
           modelAlert('请选择地区');
           return false;
        }*/
        if(hospital_name ==''){
            modelAlert('请输入医院名称!');
            return false;
        }
        if(bank_card_no ==''){
            modelAlert('请输入银行卡号!');
            return false;
        }
        if(bank_name ==''){
            modelAlert('请输入账户支行!');
            return false;
        }

        var province_id = $("#province10").find("option:selected").attr('data-code');
        var city_id = $("#city10").find("option:selected").attr('data-code');
        var region_id = $("#district10").find("option:selected").attr('data-code');

        data.doctor_name = doctor_name;
        data.id_card = id_card;
        data.province_name = province10;
        data.city_name = city10;
        data.region_name = district10;
        data.province_id = province_id;
        data.city_id = city_id;
        data.region_id = region_id;
        data.hospital_name = hospital_name;
        data.bank_card_no = bank_card_no;
        data.bank_name = bank_name;
        $('.step2').hide();
        $('.step3').show();
    })

    $('#upload').click(function(){
        $('#file').click();
    })

    $('#file').on('change',function(){
        var filename = $(this).val();
        var pos1 = filename.lastIndexOf('/');
        var pos2 = filename.lastIndexOf('\\');
        var pos = Math.max(pos1, pos2);
        if (pos > 0) {
            filename =  filename.substring(pos + 1);
        }
        $('#file_name').text(filename).parent().show();
        // alert(filename);
    })

    //七牛云上传文件
    var Qiniu_UploadUrl = "http://up-z2.qiniu.com";
    var progressbar = $("#progressbar"),
        progressLabel = $(".progress-label");
    progressbar.progressbar({
        value: false,
        change: function() {
            progressLabel.text(progressbar.progressbar("value") + "%");
        },
        complete: function() {
            progressLabel.text("Complete!");
        }
    });


    $(".step3 .btn-next").click(function() {
        var filename = $('#file_name').text();
        if(!filename){
            modelAlert('请选择要上传的协议')
        }
        //普通上传
        var Qiniu_upload = function(f, token, key) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', Qiniu_UploadUrl, true);
            var formData, startDate;
            formData = new FormData();
            if (key !== null && key !== undefined) formData.append('key', key);
            formData.append('token', token);
            formData.append('file', f);
            var taking;
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var nowDate = new Date().getTime();
                    taking = nowDate - startDate;
                    var x = (evt.loaded) / 1024;
                    var y = taking / 1000;
                    var uploadSpeed = (x / y);
                    var formatSpeed;
                    if (uploadSpeed > 1024) {
                        formatSpeed = (uploadSpeed / 1024).toFixed(2) + "Mb\/s";
                    } else {
                        formatSpeed = uploadSpeed.toFixed(2) + "Kb\/s";
                    }
                    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
                    progressbar.progressbar("value", percentComplete);
                    // console && console.log(percentComplete, ",", formatSpeed);
                }
            }, false);

            xhr.onreadystatechange = function(response) {
                if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText != "") {
                    var blkRet = JSON.parse(xhr.responseText);
                    // console && console.log(blkRet);
                    // $("#dialog").html(xhr.responseText).dialog();
                    //上传成功，跳转下一页
                    data.file = blkRet.key;
                    data.filename = filename;
                    // console.log(data)
                    $('.step3').hide();
                    $('.step4').show();
                }
            };
            startDate = new Date().getTime();
            $("#progressbar").show();
            xhr.send(formData);
        };
        var token = $("#token").val();
        if ($("#file")[0].files.length > 0 && token != "") {
            Qiniu_upload($("#file")[0].files[0], token, $("#key").val());
        } else {
            modelAlert("form input error");
        }
    })
    //上传文件结束

    $(".step3 .btn-jump,.step4 .btn-next").click(function(){
        addDoctor(data);
    })

    function addDoctor(data) {
        $.ajax({
            type: 'post',
            url: 'index/ajax',
            data: {
                'action': 'addDoctor',
                'doc_data':data,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function (XMLHttpRequest) {
            },
            success: function (json) {
                if (json.status == 1) {
                    modelAlert(json.msg);
                    $('.step').hide();
                    $('.step5').show();
                } else {
                    modelAlert(json.msg);
                }
            },
            complete: function () {
            },
            error: function () {
                modelAlert("服务器繁忙！");
            }
        });
    }
})()





