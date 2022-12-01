$('#btnAdd').click(function () {
    var a = 0;
    let c = '#userForm .form-control:visible:not(.noFilt)';
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
        data: $('#userForm').serialize(),
        dataType: 'json',
        success: function (data) {
            //console.log(data)
            if(data.error){
                $.confirm({
                    title: 'Residente no guardada',
                    content: 'Se ha encontrado un error de tipo: ' + data.error + '<br><br> <b>Intente guardar la Residente nuevamente. Si el problema persiste por favor comunicarse con el área de soporte.</b>',
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
                    title: 'Residente guardada',
                    content: 'La Residente se ha guardado con éxito.',
                    type: 'green',
                    typeAnimated: true,
                    buttons: {
                        OK: {
                            btnClass: 'bg-green-500 btn-success',
                            action: function () {
                                $('#userCreateModal').modal('hide'); 
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

$(document).ready(function(){

    $('#UsuarioTable').on('click','.viewdetails',function(){
        var empid = $(this).attr('data-id');

        if(empid > 0){

           // AJAX request
        //    var url = "{{ route('getEmployeeDetails',[':empid']) }}";
           var url = ruta2;
           url = url.replace(':usuid',empid);

           // Empty modal data
           $('#tblempinfo tbody').empty();

           $.ajax({
               url: url,
               dataType: 'json',
               success: function(response){

                   // Add employee details
                   $('#tblempinfo tbody').html(response.html);

                   // Display Modal
                   $('#viewModal').modal('show'); 
               }
           });
        }
    });

});

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
            $('#id_editar').val(data[0]['id_usu']);
            $('#primNomUpdate').val(data[0]['primerNombre']);
            $('#segNomUpdate').val(data[0]['segundoNombre']);
            $('#priApeUpdate').val(data[0]['primerApellido']);
            $('#segApeUpdate').val(data[0]['segundoApellido']);
            $('#tipoDocUpdate').val(data[0]['tipoDoc']);
            $('#identidadUpdate').val(data[0]['numeroDoc']);
            $('#fecNacUpdate').val(data[0]['fechaNacimiento']);
            $('#sexUpdate').val(data[0]['sexo']);
            $('#telUpdate').val(parseInt(data[0]['telefono']));
            $('#emailUpdate').val(data[0]['email']);
            $('#estadoUpdate').val(data[0]['idEstado']);
            $('#editModal').modal('show');
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});

//UPDATE Visita
$('#update-usuario-form').on('submit', function(e){
    e.preventDefault();

    var a = 0;
    let c = '#update-usuario-form .form-control:visible:not(.noFilt)';
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
                    title: 'Usuario no actualizado',
                    content: 'Se ha encontrado un error de tipo: ' + data.error + '<br><br> <b>Intente actualizar la Residente nuevamente. Si el problema persiste por favor comunicarse con el área de soporte.</b>',
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
                    title: 'Usuario actualizada',
                    content: 'El usuario se ha actulizado con éxito.',
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
