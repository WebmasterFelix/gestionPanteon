<style type="text/css">
<!--
	.table{
		width: 100%;
	}
	.contenido{
		padding-top:230px;
		padding-left: 155px;
	}
	.concepto{
		padding-top:-10px;
		padding-left: 155px;
	}
	.fecha{
		padding-top:30px;
		padding-left: 155px;
	}
	.usuario{
		padding-top:45px;
		padding-left: 100px;
	}
	table.page_header {width: 100%; }
-->
</style>
<page style="font-size: 12pt; font-family: arial" >
	<page_header>
        <table class="page_header">
            <tr>
				<td>
					<img src="../img/recibo_de_pago_dif.png" style="width: 100%" />
				</td>
            </tr>
        </table>
    </page_header>
	<table class="table contenido">
		<tr>
			<td><?php echo $contribuyente; ?></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td><?php echo $domicilio; ?></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td><?php echo $ciudad; ?></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td><?php echo $total_formateado; ?></td>
		</tr>
		<tr>
			<td style="width: 95%; font-size:10pt;"><?php echo $total_letras; ?></td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
	<table class="table concepto">
		<tr>
			<td style="width: 95%;"><?php echo $concepto; ?></td>
		</tr>
	</table>
	<table class="table fecha">
		<tr>
			<td style="width: 30%;"><?php echo $dia; ?></td>
			<td style="width: 60%;"><?php echo $nombreMes; ?></td>
			<td style="width: 10%;"><?php echo $añoCorto; ?></td>
		</tr>
	</table>
	<table class="table usuario">
		<tr>
			<td>Nombre Usuario</td>
		</tr>
	</table>
</page>