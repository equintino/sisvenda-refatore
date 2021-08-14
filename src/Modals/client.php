<!-- <link rel="stylesheet" href="../assets/styleCaleta.css" /> -->
<!-- <script type="text/javascript" src="../assets/scriptColeta.js"></script> -->

<style>
	#box-client {
		margin: 5px;
	}

	.icon, .hidden button {
		font-size: .8em;
		cursor: pointer;
	}

	#box-client button {
		border: none;
		float:right;
		margin-top: -22px;
		font-size: .6em;
		cursor: pointer;
	}

	.hidden button {
		display: flex;
		float: right;
		margin-bottom: -23px;
		padding: 0 10px;
		border-radius: 0 0 5px 5px;
	}
</style>
<script>
	/** functions */
	/** @var data object */
	function searchClient(data, elem=null) {
		$.ajax({
			url : "client/search",
			type: "POST",
			dataType: "JSON",
			data: data,
			beforeSend: function() {
				$(".loading").show();
				//(tabClient.destroy() ?? null);
			},
			success: function(response) {
				if(Number.isInteger(response)) {
					//if(elem !== null) {
						//openDatas(data);
					//}
					return openBoxe(data);
				}
				for(let i in response) {
					let value = (i === "Crédito" ? moeda(response[i]) : response[i]);
					$("#boxe_main [name=" + i + "]").val(value);
				}
			},
			error: function(error) {
				console.log(error);
			},
			complete: function() {
				$(".loading").hide();
			}
		});
	}

	function openBoxe(data) {
		$("#boxe2_main").load("clientes", { data }, function() {
			$(".loading").hide();
			$("#mask2_main").show();
			$(this).find("button").on("click", function() {
				if($(this).text() === "Selecionar") {
					let rowSelected = $("#boxe2_main tr.selected");
					if(rowSelected.length < 1) {
						return alertLatch("Nenhum cliente foi selecionado", "var(--cor-warning)");
					}
					let clientSelected = $("#boxe2_main tr.selected input").serializeArray();
					for(let i in clientSelected) {
						let obj = clientSelected[i];
						switch(obj.name) {
							case "ID_PJURIDICA":
								data.ID_PJURIDICA = obj.value;
								break;
							case "RasSocial":
								data.RasSocial = obj.value;
								break;
							case "CNPJ":
								data.CNPJ = obj.value;
								break;
						}
					}
					searchClient(data);
					$("#boxe2_main, #mask2_main").hide();
						// $.ajax({
						// 	url: "client/search",
						// 	type: "POST",
						// 	dataType: "JSON",
						// 	data: clientSelected,
						// 	beforeSend: function() {
						// 		$(".loading").show();
						// 	},
						// 	success: function(response) {
						// 		console.log(response);
						// 	},
						// 	error: function(error) {
						// 		console.log(error);
						// 	},
						// 	complete: function() {
						// 		$(".loading").hide();
						// 	}
						// });
				}
			});
		}).show();
	}

	/** open DataTable DB */
	function openDatas(array) {
		let obj = setObj(array);
		let columns = [];
		for(let i in array) {
			columns.push(
				{ data: i }
			);
		}
		// let columns = [
		// 	//{ data: "IDCliente"             },
		// 	{ data: "ID_PJURIDICA"             },
		// 	//{ data: "NomeCliente"           },
		// 	{ data: "RasSocial"           },
		// 	//{ data: "CNPJeCPF"              },
		// 	{ data: "CNPJ"              },
		// 	//{ data: "TipoCliente"           },
		// 	//{ data: "IDEMPRESA"             },
		// 	{ data: "IDEmpresa"             },
		// ];
		loadDataTable(columns, obj);
	}

	function setObj(array) {
		list = [];
		for(let i in array) {
			list.push({
				"name": i,
				"value": array[i]
			});
		};
		return list;
		// return {
		// 	NomeCliente, CNPJeCPF
		// };
	}

	function loadDataTable(columns, obj, elem) {
		return tabClient = $("#tabClient").DataTable({
			processing      : true,
			serverSide      : true,
			paging          : true,
			searching       : true,
			ordering        : true,
			// colReorder      : {
			// 		fixedColumnsLeft: 2,
			// 		fixedColumnsRight: 5,
			// 		reorderCallback: function() {
			// 			hideColumns();
			// 		},
			// 		realtime: true
			// },
			stateSave       : true,
			info            : true,
			lengthChange    : true,
			// aLengthMenu     : [
			// 	[ 25, 50, 100, 200, 300, 400, 500 ],
			// 	[ 25, 50, 100, 200, 300, 400, 500 ]
			// ],
			iDisplayLength  : 25,
			scrollCollapse  : true,
			scrollY         : 350,
			scrollX         : true,
			select          : {
				style: 'single'
			},
			ajax            : {
						url      : "clients",
						//enctype  : "multipart/form-data",
						type     : "POST",
						dataType : "JSON",
						data     : obj,
						async    : true,
						beforeSend: function() {
							// $("#mask_main").show();
							// $(".progress-bar").css({
							// 	width: 0 + "%"
							// }).text(0 + "%");


							// var count = 0;
							// var percent = 0;
							// var countRepeated = 0;
							// var totalRows;
							// var lastPage;
							// var extreRows = null;
							// logon = getCookie("login");

							// /** loop for progress bar */
							// let passed = 0;
							// let interval = setInterval (function() {
							// 		perc(interval);
							// 		// if(passed++ > 1000) {
							// 		//     clearInterval(interval);
							// 		// }
							// 	}, 50);
						},
						error: function(xhr, ajaxOption, thrownError) {
							// console.log(thrownError);
							// alertLatch("<span class=danger>Servidor demorou a responder, tente novamente</span>", "var(--cor-danger)");
						},
						complete: function(response) {
							// $(".loading, #mask_main").hide();
							// selectOnClick();
							// $.ajax({
							// 	url: "removeFile/file/percent_" + logon + ".txt",
							// 	type: "POST",
							// 	dataType: "JSON",
							// 	data: "percent.txt"
							// });
							// $("[name=CustoVenda]").mask("#.#00,00",{ reverse: true });
						}
			},
			// initComplete: function() {
			//     setTimeout(function(){
			//       $('.loading-overlay').remove();
			//     }, 1500);
			// },
			columns: columns,
			order: [[ 1, "desc" ]],
			language: {
					zeroRecords     : CONF_DATATABLE_ZERORECORDS,
					infoEmpty       : CONF_DATATABLE_INFOEMPTY,
					sSearch         : CONF_DATATABLE_SEARCH,
					sProcessing     : CONF_DATATABLE_PROCESSING,
					infoFiltered    : CONF_DATATABLE_INFOFILTERED,
					info            : CONF_DATATABLE_INFO,
					sLengthMenu     : CONF_DATATABLE_SLENGTHMENU,
					paginate        : {'previous': 'Anterior','next': 'Próximo'}
			},
			// footerCallback: function ( tfoot,row, data, start, end, display ) {
			// 	footerTotal(tabSale);
			// }
		});
	}






	$(document).ready(function() {
		if(table === "PFisica") {
			$("#pf").show();
			$("#pj").hide();
		} else {
			$("#pj").show();
			$("#pf").hide();
		}
		$("#box-client #btn-PJPF").on("click", function() {
			let typeForm = $(this).text();
			switch(typeForm) {
				case "MUDAR PARA PF":
					$("#pf").show();
					$("#pj").hide();
					table = "PFisica";
					$("#tp-form").text("(Pessoa Física)");
					$("#btn-PJPF").text("MUDAR PARA PJ");
					$("input").val("");
					break;
				case "MUDAR PARA PJ":
					$("#pj").show();
					$("#pf").hide();
					table = "PJuridica";
					$("#tp-form").text("(Pessoa Jurídica)");
					$("#btn-PJPF").text("MUDAR PARA PF");
					$("input").val("");
					break;
			}
		});
		$(".s-name").on("click", function() {
			let Nome = $(this).closest("div").find("input").val();
			let data = {
				ID_PFISICA: "",
				Nome,
				CPF: "",
				IDEmpresa
			};
			searchClient(data);
		});
		$(".s-cpf").on("click", function() {
			let CPF = $(this).closest("div").find("input").val();
			let data = {
				ID_PFISICA: "",
				Nome: "",
				CPF,
				IDEmpresa
			};
			searchClient(data);
		});
		$(".s-rs").on("click", function() {
			$(".loading").show();
			let RasSocial = $(this).closest("div").find("input").val();
			let data = {
				ID_PJURIDICA: "",
				RasSocial,
				CNPJ: "",
				IDEmpresa
			};
			searchClient(data);
		});
		$(".s-cnpj").on("click", function() {
			let CNPJ = $(this).closest("div").find("input").val();
			let data = {
				ID_PJURIDICA: "",
				RasSocial: "",
				CNPJ,
				IDEmpresa
			};
			searchClient(data);
		});
		$("#edit").on("click", function() {
			alert("transformar formulário para cadastro");
		});
		let data = {
			ID_PJURIDICA: "",
			RasSocial: "ro%",
			CNPJ: "",
			IDEmpresa
		};
	});
</script>

<?php
	$companyId = filter_input(INPUT_POST, "companyId", FILTER_SANITIZE_STRIPPED);
	$cnpjCpf = filter_input(INPUT_POST, "cnpjCpf", FILTER_SANITIZE_STRIPPED);
	$table = filter_input(INPUT_POST, "table", FILTER_SANITIZE_STRIPPED);
?>
<script>
	let table = '<?= $table ?>';
	let IDEmpresa = '<?= $companyId ?>';
</script>
<?php

// require __DIR__ . "/../../vendor/autoload.php";
// require __DIR__ . "/../includes/coleta.php";
// require __DIR__ . "/../includes/modalColeta.php";

//$msg = isset($msg) ? $msg : null; ?>

    <!-- <div class="msg" ><?= $msg ?></div> -->
    <div id="box-client" class="row">
		<div class="col-md-12 col-sx">
			<label>DADOS DO CLIENTE<span id="tp-form">(Pessoa Jurídica)</span> <!--<i id="register" class="fa fa-plus-circle icon" title="Cadastar Novo Cliente"></i>--> <i id="edit" class="fa fa-edit icon" title="Editar dados" style="width: 10px"></i></label>
			<div class="col-sx" id="btn-Form">
				<button id="limpa" class="btn-sm btn-outline-info ml-1" >LIMPA BUSCA</button><button id="btn-PJPF" class="btn-sm btn-outline-danger" ><?= (!empty($table) && $table ==='PFisica'?'MUDAR PARA PJ':'MUDAR PARA PF') ?></button>
			</div>
		</div>
    </div>

<?php //if(!empty($table) && $table === 'PFisica'): ?>

<div id="pf">
	<div class="p-3" id="cliente">
		<input type="hidden" name="ID_PFISICA" value="<?= isset($cDados)?$cDados['ID_PFISICA']:null ?>" />
		<input type="hidden" name="tipoC" value="P. Física" />
		<input type="hidden" name="Bloqueio" value="<?= isset($cDados)?$cDados['Bloqueio']:null ?>" />
		<input type="hidden" name="Crédito" value="<?= isset($cDados)?number_format($cDados['Crédito'],2,',','.'):null ?>" />
		<div class="row">
		<div class="col-md-5">
			<label for="Nome">Nome:</label><i class="fa fa-search ml-1 icon s-name"></i>
			<input class="form-control" type="text" name="Nome" value="<?= isset($cDados)?$cDados['Nome']:(isset($dados2->nome_da_pf)?$dados2->nome_da_pf:null); ?>"/>
		</div>
		<div class="col-md-3">
			<label for="CPF">CPF:</label><i class="fa fa-search busca ml-1 icon s-cpf"></i>
			<input class="form-control" type="text" name="CPF" value="<?= isset($cDados)?$cDados['CPF']:(isset($dados2) && is_object($dados2)?$dados2->numero_de_cpf:null); ?>" />
		</div>
		<div class="col-md-4">
			<label for="DataNasc">Data de Nascimento:</label>
			<?php
			if(isset($dados2) && is_object($dados2)) {
				$d  = explode('/',$dados2->data_nascimento);
				$dt = $d[2].'-'.$d[1].'-'.$d[0];
			}

					$dt = isset($cDados) ?
							substr($cDados['DataNasc'],0,10) : ( isset($dados2) ?
									$dt:null );
			?>
			<input class="form-control" type="date" name="DataNasc" value="<?= $dt ?>"/>
		</div>
		</div><!-- row -->
		<div class="row">
		<div class="col-md-3">
			<label for="TelResid">Telefone:</label>
			<input class="form-control" type="text" name="TelResid" value="<?= isset($cDados)?$cDados['TelResid']:null ?>"/>
		</div>
		<div class="col-md-3">
			<label for="Celular">Celular:</label>
			<input class="form-control" required type="text" name="Celular" value="<?= isset($cDados)?$cDados['Celular']:null ?>"/>
		</div>
		<div class="col-md-6">
			<label for="Email">E-mail:</label>
			<input class="form-control" required type="email" name="Email" value="<?= isset($cDados)?$cDados['Email']:null ?>"/>
		</div>
		</div><!-- row -->
		<div class="row">
		<div class="col-md-6">
			<label for="Rua">Endereço:</label>
			<input class="form-control" required type="text" name="Rua" value="<?= isset($cDados)?$cDados['Rua']:null ?>"/>
		</div>
		<div class="col-md-2">
			<label for="Num">Numero:</label>
			<input class="form-control" required type="text" name="Num" value="<?= isset($cDados)?$cDados['Num']:null ?>"/>
		</div>
		<div class="col-md-4">
			<label for="Complemento">Complemento:</label>
			<input class="form-control" type="text" name="Complemento" value="<?= isset($cDados)?$cDados['Complemento']:null ?>"/>
		</div>
		</div><!-- row -->
		<div class="row">
		<div class="col-md-4">
			<label for="Bairro">Bairro:</label>
			<input class="form-control" required type="text" name="Bairro" value="<?= isset($cDados)?$cDados['Bairro']:null ?>"/>
		</div>
		<div class="col-md-3">
			<label for="Cidade">Cidade:</label>
			<input class="form-control" required type="text" name="Cidade" value="<?= isset($cDados)?$cDados['Cidade']:null ?>"/>
		</div>
		<div class="col-md-2">
			<label for="UF">UF:</label>
			<input class="form-control" required type="text" style="text-transform:uppercase" name="UF" value="<?= isset($cDados)?$cDados['UF']:null ?>"/>
		</div>
		<div class="col-md-3">
			<label for="CEP">CEP:</label><i class="fa fa-search buscaCep ml-1 icon"></i>
			<input class="form-control" required type="text" name="CEP" value="<?= isset($cDados)?$cDados['CEP']:null ?>"/>
		</div>
		</div><!-- row -->
	</div>
</div><!-- id pf -->

<?php //elseif(!empty($table) && $table === 'PJuridica'): ?>

<div id="pj">
    <div class="p-3" id="cliente2">
	<input type="hidden" name="ID_PJURIDICA" value="<?= isset($cDados)?$cDados['ID_PJURIDICA']:null ?>" />
	<input type="hidden" name="tipoC" value="P. Juridica" />
	<input type="hidden" name="Bloqueio" value="<?= isset($cDados)?$cDados['Bloqueio']:null ?>" />
	<input type="hidden" name="Crédito" value="<?= isset($cDados)?number_format($cDados['Crédito'],2,',','.'):null ?>" />
	<div class="row">
	    <div class="col-md-5">
			<label for="RasSocial">Razão Social:</label><i class="fa fa-search busca ml-1 icon s-rs"></i>

			<?php
				/* confere se existe dados da receita */
				if(isset($dados2)) {
					$t = explode('/',$dados2['telefone']);
					if(count($t)>1) {
						$Tel01 = $t[0];
						$Tel02 = $t[1];
						$$Tel02 = trim(substr($Tel02,5,2))===9?'Celular':'Telefone';
					} else {
						$Tel01=$t[0];
					}
				} ?>

			<input class="form-control" type="text" name="RasSocial" value="<?= isset($cDados)?$cDados['RasSocial']:(isset($dados2)?$dados2['nome']:null); ?>"/>
	    </div>
	    <div class="col-md-3">
			<label for="cnpj">CNPJ:</label><i class="fa fa-search busca ml-1 icon s-cnpj"></i>
			<input class="form-control" type="text" name="CNPJ" value="<?= isset($cDados)?$cpf_cnpj:(isset($dados2)?$dados2['cnpj']:null) ?>" />
			</div>
			<div class="col-md-4">
			<label for="InscEstadual">Inscrição Estadual:</label>
			<input class="form-control" type="text" name="InscEstadual" value="<?= isset($cDados)?$cDados['InscEstadual']:null ?>"/>
	    </div>
	</div><!-- row -->
	<div class="row">
	    <div class="col-md-3">
			<label for="Tel01">Telefone:</label>
			<input class="form-control" required type="text" name="Tel01" value="<?= isset($cDados)?$cDados['Tel01']:(isset($Tel01)?$Tel01:null) ?>"/>
			</div>
			<div class="col-md-3">
			<label for="Tel02"><?= isset($$Tel02)?$$Tel02:'Celular' ?>:</label>
			<input class="form-control" type="text" name="Tel02" value="<?= isset($cDados)?$cDados['Tel02']:(isset($Tel02)?$Tel02:null) ?>"/>
			</div>
			<div class="col-md-6">
			<label for="Email">E-mail:</label>
			<input class="form-control" type="email" name="Email" value="<?= isset($cDados)?$cDados['Email']:(isset($dados2)?$dados2['email']:null) ?>"/>
	    </div>
	</div><!-- row -->
	<div class="row">
	    <div class="col-md-6">
		<label for="Rua">Endereço:</label>
		<input class="form-control" required type="text" name="Rua" value="<?= isset($cDados)?$cDados['Rua']:(isset($dados2)?$dados2['logradouro']:null) ?>"/>
	    </div>
	    <div class="col-md-2">
		<label for="Num">Numero:</label>
		<input class="form-control" required type="text" name="Num" value="<?= isset($cDados)?$cDados['Num']:(isset($dados2)?$dados2['numero']:null) ?>"/>
	    </div>
	    <div class="col-md-4">
		<label for="Complemento">Complemento:</label>
		<input class="form-control" type="text" name="Complemento" value="<?= isset($cDados)?$cDados['Complemento']:(isset($dados2)?$dados2['complemento']:null) ?>"/>
	    </div>
	</div><!-- row -->
	<div class="row">
	    <div class="col-md-4">
		<label for="Bairro">Bairro:</label>
		<input class="form-control" required type="text" name="Bairro" value="<?= isset($cDados)?$cDados['Bairro']:(isset($dados2)?$dados2['bairro']:null) ?>"/>
	    </div>
	    <div class="col-md-3">
		<label for="Cidade">Cidade:</label>
		<input class="form-control" required type="text" name="Cidade" value="<?= isset($cDados)?$cDados['Cidade']:(isset($dados2)?$dados2['municipio']:null) ?>"/>
	    </div>
	    <div class="col-md-2">
		<label for="UF">UF:</label>
		<input class="form-control" required style="text-transform:uppercase" type="text" name="UF" value="<?= isset($cDados)?$cDados['UF']:(isset($dados2)?$dados2['uf']:null) ?>"/>
	    </div>
	    <div class="col-md-3">
		<label for="CEP">CEP:</label><i class="fa fa-search buscaCep2 ml-1 icon"></i>
		<input class="form-control" required type="text" name="CEP" value="<?= isset($cDados)?$cDados['CEP']:(isset($dados2)?$dados2['cep']:null) ?>"/>
	    </div>
	</div><!-- row -->
    </div>
</div><!-- id pj -->

<?php //endif ?>

<div class="hidden">
    <button class="btn-mx btn-success ml-1" id="seleciona">Selecionar</button>
    <button class="btn-mx btn-default" id="cancela">Cancelar</button>
</div>

<!-- área oculta -->
<div id="add"></div>

<!-- <table id="tabClient" class="table-striped compact display nowrap" width="100%" >
	<thead>
		<tr>
			<th>IDCliente</th>
			<th>NomeCliente</th>
			<th>CNPJeCPF</th>
			<!-- <th>TipoCliente</th> -->
			<!--<th>IDEMPRESA</td>
		</tr>
	</thead>
</table> -->
