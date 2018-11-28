<!doctype html>
<html lang="pt-br">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.css">

<title>Bubu Turismo</title>
</head>

<body>


<div class="bg-gradient-dark">sdsd </div>

	<div class="table-responsive text-center">
		<table class="table table-bordered table-hover ">
			<tr class="bg-primary ">
				<td class=""><b>Pacote		</b></td>
				<td class=""><b>Diarias		</b></td>
				<td class=""><b>Aéreo		</b></td>
				<td class=""><b>Traslado	</b></td>
				<td class=""><b>Hospedagem	</b></td>
				<td class=""><b>Passeios	</b></td>
				<td class=""><b>Status		</b></td>
				<td class=""><b>Ações		</b></td>
			</tr>
			
			
			<?php for($i=0 ;$i < 5 ; $i++ ){
			     echo '
                        <tr class="">
                			<td class="">Natal em Gramado</td>
                			<td class="">5</td>
                			<td class="">Incluso</td>
                			<td class="">Incluso</td>
                			<td class="">Não incluido</td>
                            <td class="">Passeios</td>
                            <td class="">Confirmado</td>
                            <td class="">
                                <a href="#" > Detalhar</a>
                                <a href="#" > Editar</a>
                                <a href="#" > Cancelar</a>
                            </td>
                		</tr>
                    ';}
			?>
			
		</table>
	</div>


</body>

</html>