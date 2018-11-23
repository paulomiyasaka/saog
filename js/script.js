$(document).ready(function(){
	
	$('[data-toggle="tooltip"]').tooltip();

	verTime();

	$('#myModal').modal('hide');
	$("#modalCadastroOK").modal('hide');
	$("#modalCadastroError").modal('hide');


	$("#matricula_login").mask('0.000.000-0');
	$("#matricula_gerente").mask('0.000.000-0');
	$("#tel_gerente").mask('00000-0000');
	$("#tel_gerente2").mask('00000-0000');
	$("#tel_centro").mask('0000-0000');
	$("#data_inicio").mask('00/00/0000');
	$("#data_final").mask('00/00/0000');

	$("[horario1]").mask('00:00');
	$("[horario2]").mask('00:00');
	$("[horario3]").mask('00:00');
	$("[horario4]").mask('00:00');

	

	if (typeof(Storage) !== 'undefined') {
	    // Store
	    $("#nome_usuario").prepend(localStorage.getItem('nome'));

	    					    
	} else {
	    alert('Utilize um destes navegadores: Google Chrome ou Mozilla Firefox');
	}
	

	//listarDistritos();

	$("button").click(function(){
		verTime();
	});

		

	
});//ready()


function escolha(escolha){


	if(escolha == 0){
		$("#apoiador").removeClass('text-dark text-muted');
		$("#apoiador").addClass('text-primary');
		$("#motorista").removeClass('text-primary');
		$("#motorista").addClass('text-dark text-muted');
		$("#escolha").html("Escolhido: Apoio");

	
	}else if(escolha == 1){
		$("#apoiador").removeClass('text-primary');
		$("#apoiador").addClass('text-dark text-muted');
		$("#motorista").removeClass('text-dark text-muted');
		$("#motorista").addClass('text-primary');
		$("#escolha").html("Escolhido: Motorista");
	}

	

}





function arrayPresenca(){
	$("#modalPresenca").modal('hide');
	id_cadastrado = new Array();
	camposMarcados1 = new Array();
	camposMarcados2 = new Array();
	camposMarcados3 = new Array();
	camposMarcados4 = new Array();

	$("input[type=hidden][name='user[]']").each(function(){
	    id_cadastrado.push($(this).val());
	});
	$("input[type=text][horario1='horario1[]']").each(function(){
	    camposMarcados1.push($(this).val());
	});
	$("input[type=text][horario2='horario2[]']").each(function(){
	    camposMarcados2.push($(this).val());
	});
	$("input[type=text][horario3='horario3[]']").each(function(){
	    camposMarcados3.push($(this).val());
	});
	$("input[type=text][horario4='horario4[]']").each(function(){
	    camposMarcados4.push($(this).val());
	});
	var id_plantao = $("#pre_id_plantao").val();


	var quant = id_cadastrado.length;
	if(quant > 0){

		for (var i = 0; i <= quant; i++) {
			
			if(camposMarcados1[i]  == ""){
				camposMarcados1[i] = null;
			}
			if(camposMarcados2[i]  == ""){
				camposMarcados2[i] = null;
			}
			if(camposMarcados3[i]  == ""){
				camposMarcados3[i] = null;
			}
			if(camposMarcados4[i]  == ""){
				camposMarcados4[i] = null;
			}
		

		}


	}
	


	
		//alert("1: "+camposMarcados1+" 2: "+camposMarcados2+" 3: "+camposMarcados3+" 4: "+camposMarcados4+" id: "+id_plantao);
	
	var acao = "presenca";
	//var acao = "";
	$.ajax({url: "plantao.php", 
				data: {	
						id_plantao:id_plantao,
						id_cadastrado:id_cadastrado,
						acao:acao,
						camposMarcados1:camposMarcados1,
						camposMarcados2:camposMarcados2,
						camposMarcados3:camposMarcados3,
						camposMarcados4:camposMarcados4
					},

				datatype: 'json',
				type: 'POST',

			success: function(result,status){
				/*
				var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';
				//$("#modalUnidade").modal('hide');
				//alert("retorno = "+retorno + " success = " + status);					
				var r = retorno.split(':');			    		
				var resultado = r[1];
				var tamanho = resultado.length;

				resultado = resultado.replace(resultado.substring(0,1),"");
				
				//tamanho = resultado.length;
				//resultado = resultado.replace(resultado.substring(tamanho-6,tamanho),"");
				
				//alert("resultado = "+result);
				*/
				window.location.reload(); 

				/*
				if(resultado == 'true' && status == 'success'){   	 		
	    		
	    			$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload(); 
					})

	    		}else{
	    			$("#modalCadastroError").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload(); 
					})
	    		}
	    		*/

		},

        }); //ajax


}

function listarDistritos(){

	var id_unidade = $("#id_unidade").val();
	$("#lista_roteiros").html("");

	$.ajax({
		url: 'distritos.php',
		type: 'POST',
		data:{
			acao: 'consultar',
			id_unidade: id_unidade
		},
		success: function(result){
			
			$("#lista_distritos").html(result);
			
		}
	});


}


function listarRoteiros(){

	var id_distrito = $("#id_distrito").val();
	
	$.ajax({
		url: 'distritos.php',
		type: 'POST',
		data:{
			acao: 'roteiros',
			id_distrito: id_distrito
		},
		success: function(result){
			
			$("#lista_roteiros").html(result);
			
		}
	});


}




function cadastrarUnidade(){

		var nome = $("#nome_unidade").val();
		var trabalho = $("#tipo_trabalho").val();
		var endereco = $("#endereco").val();
		var gerente = $("#gerente").val();
		var matricula = $("#matricula_gerente").val();
		var tel_gerente = $("#tel_gerente").val();
		var tel_gerente2 = $("#tel_gerente2").val();
		var tel_centro = $("#tel_centro").val();
		var acao = "cadastrar";


		
		$.ajax({url: "../sistema/unidades.php", 
				data: {	
						nome:nome, 
						tipo_trabalho:trabalho, 
						endereco:endereco, 
						gerente:gerente,
						matricula_gerente:matricula,
						tel_gerente:tel_gerente,
						tel_gerente2:tel_gerente2,
						tel_centro:tel_centro,
						acao:acao
					},

				datatype: 'JSON',
				type: 'POST',

			success: function(result,status){
				var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';
				$("#modalUnidade").modal('hide');
				//alert("retorno = "+retorno + " success = " + status);					
				var r = retorno.split(':');			    		
				var resultado = r[1];
				var tamanho = resultado.length;

				resultado = resultado.replace(resultado.substring(0,1),"");
				
				tamanho = resultado.length;
				resultado = resultado.replace(resultado.substring(tamanho-6,tamanho),"");
				//alert("resultado = "+resultado);
				if(resultado == 'true' && status == 'success'){   	 		
	    		
	    			$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.href='../sistema/listar_plantao.php';
					})

	    		}else{
	    			$('#modalCadastroError').modal('show');
	    		}

		},

        }); //ajax


	} //cadastrar unidade


	function cadastrarDistrito(){

		var id_unidade = $("#id_unidade2").val();
		var numero_distrito = $("#numero_distrito").val();
		var roteiros = $("#roteiros").val();
		var acao = "cadastrar";


		
		$.ajax({url: "../sistema/distritos.php", 
				data: {	
						id_unidade:id_unidade, 
						numero_distrito:numero_distrito, 
						roteiros:roteiros, 						
						acao:acao
					},

				datatype: 'JSON',
				type: 'POST',

			success: function(result,status){
				var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';
				$("#modalDistrito").modal('hide');
				//alert("retorno = "+retorno + " success = " + status);					
				var r = retorno.split(':');			    		
				var resultado = r[1];
				var tamanho = resultado.length;

				resultado = resultado.replace(resultado.substring(0,1),"");
				
				tamanho = resultado.length;
				resultado = resultado.replace(resultado.substring(tamanho-6,tamanho),"");
				//alert("resultado = "+resultado);
				if(resultado == 'true' && status == 'success'){   	 		
	    		
	    			$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.href='../sistema/listar_plantao.php';
					})

	    		}else{
	    			$('#modalCadastroError').modal('show');
	    		}

		},

        }); //ajax


	} //cadastrar unidade





	function cadastrarPlantao(){

		var id_unidade = $("#id_unidade").val();
		var id_distrito = $("#id_distrito").val();
		var data_inicio = $("#data_inicio").val();
		var hora_inicio = $("#hora_inicio").val();
		var data_final = $("#data_final").val();
		var hora_final = $("#hora_final").val();
		var vagas = $("#vagas").val();
		//var motorista = $("#motorista").val();
		var motorista = $( "input[type=radio][name=motorista]:checked" ).val();
		var acao = "cadastrar";
		
		
		
		$.ajax({url: "plantao.php", 
				data: {	
						id_unidade:id_unidade, 
						id_distrito: id_distrito,
						data_inicio:data_inicio, 
						hora_inicio:hora_inicio, 
						data_final:data_final,
						hora_final:hora_final,
						vagas:vagas,
						motorista:motorista,
						acao:acao
					},

				datatype: 'JSON',
				type: 'POST',

			success: function(result,status){
				
				var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';
				$("#modalPlantao").modal('hide');
				//alert("retorno = "+retorno + " success = " + status);					
				var r = retorno.split(':');			    		
				var resultado = r[1];
				var tamanho = resultado.length;

				resultado = resultado.replace(resultado.substring(0,1),"");
				
				tamanho = resultado.length;
				resultado = resultado.replace(resultado.substring(tamanho-6,tamanho),"");
				//alert("resultado = "+resultado);
				if(resultado == 'true' && status == 'success'){   	 		
	    		
	    			$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload();
					})

	    		}else{
	    			$('#modalCadastroError').modal('show');
	    		}

		},

        }); //ajax


	} //cadastrar plantão





function logar(){

	var matricula = $("#matricula_login").val();
	
	if(matricula.length == 11){
	//var host = document.location.host;

		$.ajax({url: "sistema/login.php", 
				data: {matricula_login:matricula},
				datatype: 'JSON',
				type: 'POST',



			success: function(result,status){
				//var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';

				var retorno = "["+result+"]";				
				
				var retorno_array = retorno.split(',');
				//alert("retorno = "+retorno + " success = " + status);
						if (typeof(Storage) !== 'undefined') {
							
							if(result != false && status == 'success'){   	 		
				    					    		
				    			setStorage(retorno_array);			    						    						    		
				    			

				    		}else{
				    			$('#myModal').modal('show');
				    		}

						}else {
		    				alert('Utilize um destes navegadores: Google Chrome ou Mozilla Firefox.');
						}
        			},

        });

	}else{
		return false;
	}

	

}

function setStorage(retorno_array){
	var r = retorno_array[0].split(':');			    		
	var matricula = r[1];
	var tamanho = matricula.length;

	matricula = matricula.replace(matricula.substring(0,1),"");
	matricula = matricula.replace(matricula.substring(tamanho-2,tamanho-1),"");
	localStorage.setItem("matricula", matricula); 

	r = retorno_array[1].split(':');			    		
	var nome = r[1];
	tamanho = nome.length;
	nome = nome.replace(nome.substring(0,1),"");
	nome = nome.replace(nome.substring(tamanho-2,tamanho-1),"");
	localStorage.setItem("nome", nome);

	r = retorno_array[2].split(':');			    		
	var lotacao = r[1];
	tamanho = lotacao.length;
	lotacao = lotacao.replace(lotacao.substring(0,1),"");
	lotacao = lotacao.replace(lotacao.substring(tamanho-2,tamanho-1),"");
	localStorage.setItem("lotacao", lotacao);

	r = retorno_array[3].split(':');			    		
	var funcao = r[1];
	tamanho = funcao.length;
	funcao = funcao.replace(funcao.substring(0,1),"");
	funcao = funcao.replace(funcao.substring(tamanho-2,tamanho-1),"");
	localStorage.setItem("funcao", funcao);

	r = retorno_array[4].split(':');			    		
	var telefone = r[1];
	tamanho = telefone.length;
	telefone = telefone.replace(telefone.substring(0,1),"");
	telefone = telefone.replace(telefone.substring(tamanho-2,tamanho-1),"");
	localStorage.setItem("telefone", telefone);
	var time = new Date();
	time = time.getTime();
	localStorage.setItem("time", time);
	window.location.href = "sistema/plantao.php?acao=listar&matricula="+matricula;

}


function logout(){	
	localStorage.clear();   	
	window.location.href="logout.php";		
}

function verTime(){
	//localStorage.setItem("time", timeNow);
	if(localStorage.getItem("time") != null){

		var timeIn = localStorage.getItem("time");
		var timeNow = new Date();
		timeNow = timeNow.getTime();

		if(timeNow - timeIn > 600000){
			logout();
		}else{
			localStorage.setItem("time", timeNow);
		}

	}
}

function limparForm(){
		$("#data_inicio").val("");
		$("#data_final").val("");
		$("#hora_inicio").val("");
		$("#hora_final").val("");
		$("#vagas").val("");
		$("#exampleRadios2").removeAttr("checked");
		$("#exampleRadios1").attr("checked","");
		$("#opt_opcao").remove();
		$("#hora_ini_opt").remove();
		$("#hora_final_opt").remove();
		$("#btn_editar_plantao").attr("disabled","");
		$("#btn_editar_plantao").attr("hidden","");
		$("#btn_cadastrar_plantao").removeAttr("hidden");
		$("#alterarPlantao").attr("hidden", "");
		$("#cadastrarPlantao").removeAttr("hidden");

}


	function idPlantao(id_plantao){
		
		$("#inscrever_plantao").attr("id-plantao", id_plantao);
		$("#btn_cadastrar_plantao").removeAttr("hidden");
		$("#btn_editar_plantao").attr("hidden");
		$("#cadastrarPlantao").removeAttr("hidden");
		$("#alterarPlantao").attr("hidden", "");

		


		$.ajax({url: "plantao.php", 
				data: {
						acao:'verificar',
						id_plantao:id_plantao
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';

				var r = retorno.split(':');			    		
				var resultado = r[1];
				var tamanho = resultado.length;

				resultado = resultado.replace(resultado.substring(0,1),"");
				
				tamanho = resultado.length;
				resultado = resultado.replace(resultado.substring(tamanho-6,tamanho),"");
				
				if(resultado == 'true' && status == 'success'){   	 		
	    		
	    			$("#radio-motorista").show();

	    		}else{
	    			$("#radio-motorista").hide();
	    		}



        			},

        });




	}

	function editPlantao(id_plantao){
		limparForm();
		$("#btn_editar_plantao").attr("id_plantao", id_plantao);
		$("#modalPlantao").show();
		//$("#btn_editar_plantao").removeAttr("hidden");
		$("#btn_editar_plantao").removeAttr("hidden");
		$("#btn_cadastrar_plantao").attr("hidden", "");
		//$("#btn_cadastrar_plantao").removeAttr("hidden");
		$("#alterarPlantao").removeAttr("hidden");
		$("#cadastrarPlantao").attr("hidden", "");

		//$("#id_unidade").attr();


		
		$.ajax({url: "plantao.php", 
				data: {
						acao:"dados",
						id_plantao:id_plantao
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				var retorno = result; 
				

				var r = retorno.split(',');			    		

				var unid = r[1].split(':');
				unid[1] = unid[1].replace('"',"");
				unid[1] = unid[1].replace('"',"");
				

				 $.post("plantao.php",
				    {	
				    	acao: "unidade",
				        id_unidade: unid[1]
				        
				    },

				    function(data, status){
				        //alert("Data: " + data + "\nStatus: " + status);
				        var unidade = data.split(',');
				        unidade[1] = unidade[1].split(':');
				        unidade[2] = unidade[2].split(':'); //trabalho

				        var tipo_trabalho = unidade[2][1];
				        var nome_unidade = unidade[1][1];

				        tipo_trabalho = tipo_trabalho.replace('"',"");
				        tipo_trabalho = tipo_trabalho.replace('"',"");
				        tipo_trabalho = tipo_trabalho.replace('\\u00e7',"ç");
				        tipo_trabalho = tipo_trabalho.replace('\\u00e3',"ã");
				        nome_unidade = nome_unidade.replace('"',"");
				        nome_unidade = nome_unidade.replace('"',"");

				        var opcao = nome_unidade + " - " + tipo_trabalho;
				        //unidade[0] = unidade[0].replace('"',"");
				        //alert(opcao);
				        $("#id_unidade").prepend("<option id='opt_opcao' value='"+unid[1]+"' selected>"+opcao+"</option>");
				    });


				var data = r[3].split(' ');
				data = data[0].split(':');
				data[1] = data[1].replace('"',"");
				data[1] = data[1].replace('-',"/");
				data[1] = data[1].replace('-',"/");
				var novaData = data[1].split('/');
				novaData = novaData[2]+"/"+novaData[1]+"/"+novaData[0];

				$("#data_inicio").val(novaData);
				
				var hora = r[3].split(' ');
				hora = hora[1].split(':');
				var novaHora = hora[0]+":"+hora[1];
				

				$("#hora_inicio").prepend("<option id='hora_ini_opt' value='"+hora[0]+"' selected>"+novaHora+"</option>");

				var data = r[4].split(' ');
				data = data[0].split(':');
				data[1] = data[1].replace('"',"");
				data[1] = data[1].replace('-',"/");
				data[1] = data[1].replace('-',"/");
				var novaData = data[1].split('/');
				novaData = novaData[2]+"/"+novaData[1]+"/"+novaData[0];
				$("#data_final").val(novaData);

				var hora = r[4].split(' ');
				hora = hora[1].split(':');
				var novaHora = hora[0]+":"+hora[1];
				$("#hora_final").prepend("<option id='hora_final_opt' value='"+hora[0]+"' selected>"+novaHora+"</option>");
				//alert(novaHora);

				//$("#data_final").val(r[3]);
				var vagas = r[5].split(':');
				vagas[1] = vagas[1].replace('"',"");
				vagas[1] = vagas[1].replace('"',"");
				$("#vagas").val(vagas[1]);

				var motorista = r[6].split(':');
				motorista[1] = motorista[1].replace('"',"");
				motorista[1] = motorista[1].replace('"',"");
				//$("#motorista").val(motorista[1]);

				//alert(motorista[1]);
				if(motorista[1] == '1'){
					$("#motoristaNao").removeAttr("checked");
					$("#motoristaSim").attr("checked","");
				}else{
					$("#motoristaSim").removeAttr("checked");
					$("#motoristaNao").attr("checked","");
				}


				
        			},

        });



	}



	function habilitarAlterar(){

		$("#btn_editar_plantao").removeAttr("disabled");


	}


	function habilitarCadastrar(){
		//var cadastrar = $("#inscrever_plantao").removeAttr("class");
		//cadastrar = $("#inscrever_plantao").attr("class");
		//alert("cadastrar");
		//$("#inscrever_plantao").attr('disabled', 'false');
		
		var motorista = $( "#inscrever_plantao[btn=btn]" ).removeAttr("disabled");
		//alert(cadastrar);

	}	


function editarPlantao(){

	$("#modalPlantao").modal('hide');
		var id_plantao = $("#btn_editar_plantao").attr("id_plantao");
		var id_unidade = $("#id_unidade").val();
		var id_distrito = $("#id_distrito").val();
		var data_inicio = $("#data_inicio").val();
		var hora_inicio = $("#hora_inicio").val();
		var data_final = $("#data_final").val();
		var hora_final = $("#hora_final").val();
		var vagas = $("#vagas").val();
		//var motorista = $("#motorista").val();
		var motorista = $( "input[type=radio][name=motorista]:checked" ).val();
		var acao = "alterar";
		
		
		
		$.ajax({url: "plantao.php", 
				data: {	
						id_plantao:id_plantao,
						id_unidade:id_unidade, 
						id_distrito: id_distrito,
						data_inicio:data_inicio, 
						hora_inicio:hora_inicio, 
						data_final:data_final,
						hora_final:hora_final,
						vagas:vagas,
						motorista:motorista,
						acao:acao
					},

				datatype: 'JSON',
				type: 'POST',

			success: function(result,status){

				//alert(typeof(result)+ " " +result.length + " " + result);
				//alert(result);
				window.location.reload();
				
				/*    		
				var resultado = result;
				
				if(resultado == " 1 " && status == "success"){   	 		
	    			
	    			$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload();
					});

	    		}else{

	    			$("#modalCadastroError").modal('show').on('hidden.bs.modal', function (e) {
	    				
					  	window.location.reload();
					});
	    		}
				
				*/
	    		

		},

        }); //ajax


	} //editar plantão







	function delPlantao(id_plantao){
		
		$("#deletar_plantao").attr("id-plantao", id_plantao);
		$("#modalDelete").show();
	}

	function ativarPlantao(id_plantao){
		
		$("#reativar_plantao").attr("id-plantao", id_plantao);
		$("#modalReativar").show();
	}


	function deletarPlantao(){
		$("#modalDelete").hide();
		var id_plantao = $("#deletar_plantao").attr("id-plantao");
		var acao = "deletar";

		$.ajax({url: "plantao.php", 
				data: {
						acao:acao,
						id_plantao:id_plantao,
						
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				
							
					if(result != "false" && status == 'success'){ 
					
					 		
		    		$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload();	
					})
		    					    			

		    		}else{
		    			
		    			$('#modalCadastroError').modal('show');
		    		}

        		},

        });

	}


		function reativarPlantao(){

		$("#modalReativar").hide();
		var id_plantao = $("#reativar_plantao").attr("id-plantao");
		var acao = "reativar";

		$.ajax({url: "plantao.php", 
				data: {
						acao:acao,
						id_plantao:id_plantao,
						
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				
							
					if(result != "false" && status == 'success'){ 
					
					 		
		    		$("#modalCadastroOK").modal('show').on('hidden.bs.modal', function (e) {
					  	window.location.reload();	
					})
		    					    			

		    		}else{
		    			
		    			$('#modalCadastroError').modal('show');
		    		}

        		},

        });

	}




	function inscreverPlantao(){	

			var id_plantao = $("#inscrever_plantao").attr("id-plantao");
			var acao = "inscrever";			
			var motorista = $( "input[type=radio][name=motor]:checked" ).val();
			//alert(motorista);
			var tipo_modal = "";

			
			if(motorista == null || motorista == ""){
				motorista = 0;
				tipo_modal = $("#modalInscreverTratamento");

			}else{
				tipo_modal = $("#modalInscreverMotorista");
			}
			

			

			$.ajax({url: "plantao.php", 
				data: {
						acao:acao,
						id_plantao:id_plantao,
						motorista:motorista
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				//var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';

				//var retorno = "["+result+"]";				
				
				//var retorno_array = retorno.split(',');
				//alert(retorno_array);
				//alert("retorno = "+result + " success = " + status)
							
							if(result != "false" && status == 'success'){ 
							
							tipo_modal.modal('hide'); 	 		
				    		$('#modalCadastroOK').modal('show');
				    		window.location.reload();	
				    			

				    		}else{

				    			tipo_modal.modal('hide'); 
				    			$('#modalCadastroError').modal('show');
				    		}

        			},

        });

		
	}





function cancelarInscreverPlantao(){	

			var id_plantao = $("#inscrever_plantao").attr("id-plantao");
			var acao = "cancelar";
			var motorista = $("#motorista").val();
			if(motorista == null || motorista == ""){
				motorista = 0;
			}

			$.ajax({url: "plantao.php", 
				data: {
						acao:acao,
						id_plantao:id_plantao
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				//var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';

				var retorno = "["+result+"]";				
				
				var retorno_array = retorno.split(',');
				
				//alert("retorno = "+retorno + " success = " + status)
							
							if(result != false && status == 'success'){ 
							
							$("#modalCancelInscrever").modal('hide'); 
							//$('#modalCadastroOK').modal('show');
				    		window.location.reload();	
				    			

				    		}else{

				    			$("#modalCancelInscrever").modal('hide'); 
				    			$('#modalCadastroError').modal('show');
				    		}

        			},

        });

		
	}




	function verInscritos(id_plantao){

		$.ajax({url: "plantao.php", 
				data: {
						acao:"listar_inscritos",
						id_plantao:id_plantao
					},
				datatype: 'JSON',
				type: 'POST',

				success: function(result,status){
				//var retorno = '['+ result + ']'; 
				//var j = '{"dados":' + result + '}';

				//var retorno = "["+result+"]";				
				
				var retorno_array = result.split('},{');

				//alert(retorno_array.length);
				
				//alert("retorno = "+retorno + " success = " + status)
							
							if(retorno_array != "false" && status == 'success'){ 

								$('#modalInscritos').modal('show').on('shown.bs.modal', function (e) {
								 	//listarInscritos(retorno_array);
								 	$("table > tbody").empty();
								 	//var tamanho = (retorno_array.length)/3;		
									var tamanho = retorno_array.length/3;
								 	var linha = 0;		
								 	var i = 0;
								 	//alert(retorno_array);
								 	if(tamanho > 0){

								 		while(linha < tamanho){
								 			
								 			while(i < tamanho*3){
								 				//retorno_array[i] = retorno_array.split(',');
								 				alert(retorno_array);
								 				//retorno_array[i+1] = retorno_array.split(':');
								 				//retorno_array[i+2] = retorno_array.split(':');
								 				//alert(retorno_array);
								 				$("<tr><th scope=\"row\" class=\"h5 text-center\">"+retorno_array[i]+"</th><td class=\"h5 text-center\">"+retorno_array[i+1]+"</td><td class=\"h5 text-center\">"+retorno_array[i+2]+"</td></tr>").appendTo("tbody");
								 				i  += 3;
								 			}
								 			
								 			linha++;
								 			
								 		}
								 	}

								 		
								 									 		
								 	
								 	
								});

								
				    			
								

				    		}else{
				    			


				    			$('#modalCadastroError').modal('show');
				    		
				    		}

        			},

        });

	}















