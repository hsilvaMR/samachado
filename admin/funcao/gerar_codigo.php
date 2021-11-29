<?
function gerarCodigo($tamanho)
{
	 $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
	 $len = strlen($caracteres);
	 for ($n = 1; $n <= $tamanho; $n++)
	 {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand - 1];
	 }
	 return $retorno;
}
?>