const instance = tippy(document.querySelector('#client_email'));
instance.setProps({
    arrow: true,
    animation: 'scale',
    content: 'Ingresa un correo electrónico valido',
    trigger: 'manual',
});

$('#submit').click(function (e) {
    e.preventDefault();
    if ($('#client_email').val()) {
        if (emailIsValid($('#client_email').val())) {
            const email = $("#client_email").val();
            $.ajax({
                type: "POST",
                url: 'config/ServiceWeb.php',
                data: {
                    email: email
                },
                success: function (response) {
                    const dataJSON = JSON.parse(response);
                    if (dataJSON.status == "ok") {
                        swal({
                            title: "Bienvenido a Ktdra",
                            text: "¡Te enviaremos promociones y descuentos exclusivos!",
                            icon: "success",
                            button: "Aceptar",
                        });
                    }
                    else if(dataJSON.status == "error"){
                        instance.setProps({
                            content: 'Ya existe este correo electrónico registrado',                         
                        });
                        instance.show(5000);
                    }
                },
                error: function (error) {
                    console.log(error.statusText);
                }
            })
        } else {
            instance.show(5000);
        }
    } else {
        instance.show(5000);
    }
});




function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
}