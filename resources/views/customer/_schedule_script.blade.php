<link rel="stylesheet" href="{{ URL::to('/') }}/css/daterangepicker.css" rel="stylesheet">
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" /> 

<script src="{{ URL::to('/') }}/js/jquery-3.5.1.min.js"></script>
<script src="{{ URL::to('/') }}/js/jquery-ui.js"></script>
<script src="{{ URL::to('/') }}/js/daterangepicker.js"></script>

<script>
    function messageType(type)
    {
        if(type == 'immediate')
        {
            $('#schedule').hide();
            $('#submit').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></i> {{__("locale.buttons.send")}}');
        }else{
            $('#schedule').show();
            $('#submit').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg></i> {{__("locale.buttons.save")}}');
        }

    }

    jQuery(document).ready(function ($) {
    $("#date").datepicker({
                dateFormat: "yy-mm-dd",//"dd-mm-yy",
                changeMonth: true,
                changeYear: true,
                minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                numberOfMonths: 1,
                // beforeShowDay: unavailable
                beforeShowDay: function(date){

                    var editTempId = $("#date").attr("data-edit_temp_id");
                    if(editTempId == "0"){
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                        return [true, ""];
                    }
                    else{
                        dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                        const dtData = [];
                        
                        if ($.inArray(dmy, dtData) == -1) {
                            return [true, ""];
                        } else {
                            return [false, "", "Unavailable"];
                        }
                    }
                }
            });

            $("#date").change(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var date = $(this).val();
                $('#hours').removeAttr('disabled');
                $('#minutes').attr('disabled','disabled');
                $.ajax({
                    url : "{{ URL::to('/') }}/check-campaign",
                    type : 'POST',
                    dataType : "JSON",
                    data : {
                        date: date,
                        "_token": CSRF_TOKEN
                    },
                    success : function(res) {
                        $('#hours').html(res.hours);
                        $('#minutes').html(res.minutes);
                    }
                });
            });
            $("#hours").change(function(){
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var date = $('#date').val();
                var hour = $(this).val();
                $('#minutes').removeAttr('disabled');
                $.ajax({
                    url : "{{ URL::to('/') }}/check-campaign-hours",
                    type : 'POST',
                    dataType : "JSON",
                    data : {
                        date: date,
                        hour: hour,
                        "_token": CSRF_TOKEN
                    },
                    success : function(res) {
                        $('#minutes').html(res.minutes);
                    }
                });
            });
        });
</script>