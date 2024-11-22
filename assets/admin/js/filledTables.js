$(document).on('keyup', '#table', function () {
        
    var myFormData = new FormData($('#form_id')[0])
    if ($('#table').val() != null && $('#table').val() > 0) {
        $.ajax({
            type:       'post',
            url:        "{{route('receipt.entry.check.table')}}",
            data:    {
                '_token': "{{csrf_token()}}",
                'table_id': $('#table').val(),
            },
            success: function (response) {
                
                var tableInfo = '';
                
                if (response == '') {
                    $('#submitEntry').attr('type', 'button')
                    $('button#submitEntry').css('color', 'darkgrey')
                    $('#tableQuery > .result').css('display', 'none');
                    $('#notFound').css('display', 'block')
                    $('.tableNumber').html($('#table').val())
                    $('#tableName').val($('#table').val())
                    
                } else {
                    if (response.status == '0') {
                        $('#tableQuery > .result').css('display', 'none');
                        $('#tableFree').css('display', 'block')
                        $('.tableNumber').html($('#table').val())
                       
                    }
                    if (response.status == '1') {
                        $('#tableQuery > .result').css('display', 'none');
                        $('#tableBusy').css('display', 'block')
                        $('.tableNumber').html($('#table').val())
                        $('#contract').html(response.the_contract.code + " - " + response.the_client.name)
                        $('#load').html(response.the_load)
                    }
                    var theLoad = response.the_load = 0 ? 'فارغة' : response.the_load;
                    tableInfo = '<b>الطبلية رقم:</b> '+response.name+''
                }
                
                console.log(response.the_client.name)
                
            },
            error: function () {

            }
        })
    } else {
        $('#tableQuery > div').css('display', 'none');
    }

    let number = 2
    let result = number.toString().padStart(7, '450000')
    
});
// $('form').on('change', function () {
//     console.log('changed')
//     alert($(this).attr('id'));
// });