$('#btnAdd').click(function () {
    var a = 0;
    let c = '#AptoForm .form-control:visible:not(.noFilt)';
    $(c).each(function () {
        if ($(this).val() == '') {
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
            a++;
        } else {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        }
    });

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ruta,
        type: 'POST',
        data: $('#AptoForm').serialize(),
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            if(data.error){
                $.confirm({
                    title: 'Apartamento no guardado',
                    content: 'Se ha encontrado un error de tipo: ' + data.error + '<br><br> <b>Intente guardar el apartamento nuevamente. Si el problema persiste por favor comunicarse con el área de soporte.</b>',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Ok',
                            btnClass: 'btn-red',
                        }                        
                    }
                }); 
               return;
            }else if(data.success){
                $.confirm({
                    title: 'Apartamento guardado',
                    content: 'El apartamento se ha guardado con éxito.',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        OK: {
                            btnClass: 'bg-green-500 btn-success',
                            action: function () {
                                $('#largeModal').modal('hide'); 
                                location.reload();
                            }
                        }
                    }
                });
            }

        //    alert(data.success); // THis is success message
       },
       error: function (result) {
        $('#errors-modal').removeClass('d-none');
        var resulta = JSON.parse(result.responseText)
        var valor = '';
        var x = resulta.errors;
        // console.log(x);
        $('#ul-errors').empty();
        for (let i in x) {
            // valor += '<li>Campo '+i+' Error: '+x[i][0]+'</li>';
            valor += '<li>'+x[i][0]+'</li>';
        }
        $('#ul-errors').append(valor);
        // alert(resulta.errors)
       }
    });
});  
//FIN CREAR APARTAMENTO


//display modal form for product EDIT ***************************
$(document).on('click','.open_modal',function(){
    var visita_id = $(this).val();
    var url5 = $('#url').val();
    // Populate Data in Edit Modal Form
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url5 + '/edit/' + visita_id,
        success: function (data) {
            // console.log(url);
            // console.log(data);
            $('#id_editar').val(data[0]['id_apto']);
            $('#numeroAptoNew').val(parseInt(data[0]['numeroApto']));
            $('#numeroTorreNew').val(data[0]['numeroTorre']);
            $('#estadoNew').val(data[0]['estado']);
            $('#proAptoNew').val(data[0]['idUsuario']);
            $('#editModal').modal('show');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});



//UPDATE Visita
$('#update-apto-form').on('submit', function(e){
    e.preventDefault();

    var a = 0;
    let c = '#update-apto-form .form-control:visible:not(.noFilt)';
    $(c).each(function () {
        if ($(this).val() == '') {
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
            a++;
        } else {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        }
    });

    var form = this;
    console.log(form)
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data: new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend: function(){
             $(form).find('span.error-text').text('');
        },
        success: function(data){
            console.log(data)
            if(data.error){
                $.confirm({
                    title: 'Apartamento no actualizado',
                    content: 'Se ha encontrado un error de tipo: ' + data.error + '<br><br> <b>Intente actualizar la visita nuevamente. Si el problema persiste por favor comunicarse con el área de soporte.</b>',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Ok',
                            btnClass: 'btn-red',
                        }                        
                    }
                }); 
               return;
            }else if(data.success){
                $.confirm({
                    title: 'Apartamento actualizada',
                    content: 'El Apartamento se ha actulizado con éxito.',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        OK: {
                            btnClass: 'bg-green-500 btn-success',
                            action: function () {
                                $('#largeModal').modal('hide'); 
                                location.reload();
                            }
                        }
                    }
                });
            }
        },
        error: function (result) {
            $('#errors-modal-update').removeClass('d-none');
            var resulta = JSON.parse(result.responseText)
            var valor = '';
            var x = resulta.errors;
            console.log(x);
            $('#ul-errors-update').empty();
            for (let i in x) {
                valor += '<li>'+x[i][0]+'</li>';
            }
            $('#ul-errors-update').append(valor);
           }
    });
});