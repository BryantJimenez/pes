$(document).ready(function(){
	//Usuarios login
	$("button[action='login']").on("click",function(){
		$("#formLogin").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='login']").attr('disabled', true);
				form.submit();
			}
		});
	});

	//Usuarios register
	$("button[action='register']").on("click",function(){
		$("#formRegister").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				terms: {
					required: true
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				}
			},
			submitHandler: function(form) {
				$("button[action='register']").attr('disabled', true);
				form.submit();
			}
		});
	});

	//Recuperar Contraseña
	$("button[action='recovery']").on("click",function(){
		$("#formRecovery").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				},

				recovery: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				}
			},
			submitHandler: function(form) {
				$("button[action='recovery']").attr('disabled', true);
				form.submit();
			}
		});
	});

	//Restaurar Contraseña
	$("button[action='reset']").on("click",function(){
		$("#formReset").validate({
			rules:
			{
				email: {
					required: true,
					email: true,
					minlength: 5,
					maxlength: 191
				},

				password: {
					required: true,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='reset']").attr('disabled', true);
				form.submit();
			}
		});
	});

	//Perfil
	$("button[action='profile']").on("click",function(){
		$("#formProfile").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				password: {
					required: false,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: { 
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			submitHandler: function(form) {
				$("button[action='profile']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Usuarios (Registrar)
	$("button[action='user']").on("click",function(){
		if ($("#formUser").length) {
			$("#formUser").validate().destroy();
		}
		var value=true;
		if ($('select[name="type"]').val()=="Promovido") {
			value=false;
		}
		$("#formUser").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: value,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				type: {
					required: true
				},

				colony_id: {
					required: true
				},

				section_id: {
					required: true
				},

				promoter: {
					required: true
				},

				password: {
					required: value,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: {
					required: value,
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				type: {
					required: 'Seleccione una opción.'
				},

				colony_id: {
					required: 'Seleccione una opción.'
				},

				section_id: {
					required: 'Seleccione una opción.'
				},

				promoter: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='user']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Usuarios (Editar)
	$("button[action='user']").on("click",function(){
		if ($("#formUserEdit").length) {
			$("#formUserEdit").validate().destroy();
		}
		var value=true, email=false;
		if ($('select[name="type"]').length && $('select[name="type"]').val()=="Promovido") {
			value=false;
		}
		if ($('input[name="email"]').length) {
			email=true;
		}
		$("#formUserEdit").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: email,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				type: {
					required: true
				},

				colony_id: {
					required: true
				},

				section_id: {
					required: true
				},

				promoter: {
					required: true
				},

				password: {
					required: false,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: {
					required: false,
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				email: {
					remote: "Este correo ya esta en uso."
				},

				type: {
					required: 'Seleccione una opción.'
				},

				colony_id: {
					required: 'Seleccione una opción.'
				},

				section_id: {
					required: 'Seleccione una opción.'
				},

				promoter: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='user']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Códigos Postales
	$("button[action='zip']").on("click",function(){
		$("#formZip").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 5,
					maxlength: 5
				}
			},
			submitHandler: function(form) {
				$("button[action='zip']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Colonias
	$("button[action='colony']").on("click",function(){
		$("#formColony").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				zip_id: {
					required: true
				}
			},
			messages:
			{
				zip_id: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='colony']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Secciones
	$("button[action='section']").on("click",function(){
		$("#formSection").validate({
			rules:
			{
				name: {
					required: true,
					minlength: 4,
					maxlength: 4
				},

				colony_id: {
					required: true
				}
			},
			messages:
			{
				colony_id: {
					required: 'Seleccione una opción.'
				}
			},
			submitHandler: function(form) {
				$("button[action='section']").attr('disabled', true);
				form.submit();
			}
		});
	});

	// Registro desde promotor
	var formPromoter;
	$("button[action='promoter']").on("click",function(){
		if (formPromoter) {
			formPromoter.destroy();
		}
		var value=true;
		if ($('#disabledType').val()=="Promovido") {
			value=false;
		}
		formPromoter=$("#formPromoter").validate({
			rules:
			{
				photo: {
					required: true
				},

				name: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				lastname: {
					required: true,
					minlength: 2,
					maxlength: 191
				},

				email: {
					required: value,
					email: true,
					minlength: 5,
					maxlength: 191,
					remote: {
						url: "/usuarios/email",
						type: "get"
					}
				},

				phone: {
					required: true,
					minlength: 5,
					maxlength: 15
				},

				password: {
					required: value,
					minlength: 8,
					maxlength: 40
				},

				password_confirmation: {
					required: value,
					equalTo: "#password",
					minlength: 8,
					maxlength: 40
				}
			},
			messages:
			{
				photo: {
					required: 'Seleccione una imagen.'
				},

				email: {
					remote: "Este correo ya esta en uso."
				}
			},
			submitHandler: function(form) {
				$("button[action='promoter']").attr('disabled', true);
				form.submit();
			}
		});
	});
});