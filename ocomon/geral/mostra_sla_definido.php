<?
 /*                        Copyright 2005 Fl�vio Ribeiro

         This file is part of OCOMON.

         OCOMON is free software; you can redistribute it and/or modify
         it under the terms of the GNU General Public License as published by
         the Free Software Foundation; either version 2 of the License, or
         (at your option) any later version.

         OCOMON is distributed in the hope that it will be useful,
         but WITHOUT ANY WARRANTY; without even the implied warranty of
         MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         GNU General Public License for more details.

         You should have received a copy of the GNU General Public License
         along with Foobar; if not, write to the Free Software
         Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");


?>
<script type='text/javascript'>

	function popup_alerta(pagina)	{ //Exibe uma janela popUP
		x = window.open(pagina,'_blank','width=700,height=470,scrollbars=yes,statusbar=no,resizable=yes');
		x.moveTo(window.parent.screenX+50, window.parent.screenY+50);
		return false
	}
</script>
<?

print "<HTML><head><title>SLA Definido</title></head>";
print "<BODY bgcolor='".BODY_COLOR."'>";
	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);

	$sql = "SELECT o.numero as numero, p.problema as problema, l.local as local, resp.slas_desc as resposta, ".
		"sol.slas_desc as solucao ".
		"FROM ".
			"ocorrencias as o, prioridades as pr, sla_solucao as sol ".
			"LEFT JOIN problemas as p on p.prob_sla = sol.slas_cod ".
			"LEFT JOIN localizacao as l on l.loc_prior = pr.prior_cod ".
			"LEFT JOIN sla_solucao as resp on resp.slas_cod = pr.prior_sla ".
		"WHERE ".
			"o.problema = p.prob_id and o.local = l.loc_id and o.numero = ".$_GET['numero']."";

	$exec_sql = mysql_query($sql) or die ('ERRO: <br>'.$sql);
	$row=mysql_fetch_array($exec_sql);

	print "<br><b>SLAs para a ocorr�ncia <font color='red'>".$_GET['numero']."</font>:</b><br>";
	print "<table cellspacing='0' border='1' cellpadding='1' align='left' width='100%'>";
		print "<tr><td width='20%'><b>Setor:</b></td><td width='30%'>".NVL($row['local'])."</td><td width='20%'><b>Problema:</b></td><td width='30%'>".NVL($row['problema'])."</td></tr>";
		print "<tr><td width='20%'><b>SLA de Resposta:</b></td><td width='30%'>".NVL($row['resposta'])."</td><td width='20%'><b>SLA de Solu��o:</b></td><td width='30%'>".NVL($row['solucao'])."</td></tr>";
	print "</table>";

print "</body>";
print "</html>";
?>