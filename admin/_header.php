<header>
	<a href="/" target="_bank"><img src="/admin/icon/logo-preto.svg" class="headerLogo"></a>
	<span class="headerLogout lnr lnr-exit" onClick="window.location.href='/admin';"></span>
	<!--<div class="headerLogout" onClick="window.location.href='/admin';"></div>-->
	<div class="headerNome"><?php echo $nome_user; ?></div>
</header>

<!-- LOADING -->
<div id="LOADING" class="modal">
	<div class="modalFundo"></div>
	<div class="modalSize">
		<div class="modalHead">Aguarde...</div>
		<div class="modalGif"><img src="/admin/icon/loading.gif"></div>
	</div>
</div>
<!-- -->