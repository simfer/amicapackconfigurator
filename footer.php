</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap Table Javascript -->
<script src="bower_components/bootstrap-table/dist/bootstrap-table.min.js"></script>
<script src="bower_components/bootstrap-table/dist/locale/bootstrap-table-it-IT.min.js"></script>

<!-- Bootstrap Dialog JavaScript -->
<script src="bower_components/bootstrap3-dialog/dist/js/bootstrap-dialog.js"></script>

<!-- Bootstrap Datepicker JavaScript -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.it.min.js"></script>

<!-- Toastr -->
<script src="bower_components/toastr/toastr.min.js"></script>

<script src="bower_components/jquery-validation/dist/jquery.validate.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist/js/sb-admin-2.js"></script>

<!-- MD5 Plugin -->
<script src="js/jquery.md5.js"></script>

<script type="text/javascript">
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    var message = localStorage.message;
    var messagetype = localStorage.messagetype;

    if (message && message !== "") {
        var messagetype = localStorage.messagetype;
        if (messagetype == "success") {
            toastr.info("OK: " + message);
        } else {
            toastr.error("ERRORE: " + message);

        }
        localStorage.messtype = "";
        localStorage.message = "";
    }

    jQuery.validator.setDefaults({
        highlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).addClass(errorClass).removeClass(validClass);
            } else {
                $(element).closest('.cell').removeClass('has-success has-feedback').addClass('has-error has-feedback');
                $(element).closest('.cell').find('i.fa').remove();
                //$(element).closest('.col-sm-3').append('<i class="fa fa-exclamation fa-lg form-control-feedback"></i>');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            if (element.type === "radio") {
                this.findByName(element.name).removeClass(errorClass).addClass(validClass);
            } else {
                $(element).closest('.cell').removeClass('has-error has-feedback').addClass('has-success has-feedback');
                $(element).closest('.cell').find('i.fa').remove();
                //$(element).closest('.col-sm-3').append('<i class="fa fa-check fa-lg form-control-feedback"></i>');
            }
        }
    });

    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }

    function getHeight() {
        return $(window).height() - $('h1').outerHeight(true);
    }

    function DateFormatWEB(d) {
        if(d) {
            var str=d.split("-");
            return(str[2]+"/" + str[1]+ "/"+str[0]);
        } else {
            return("");
        }
    }

    function DateFormatDB(d) {
        if(d) {
            var str=d.split("/");
            return(str[2]+"-" + str[1]+ "-"+str[0]);
        } else {
            return("NULL");
        }
    }

</script>

</body>

</html>
