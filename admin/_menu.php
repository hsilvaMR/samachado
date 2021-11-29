<?php $id_user = $_SESSION['id_user']; ?>
<div class="menuLateral">
    <div id="menuSlide" class="DN1024">
        <h3 class="menuTlm"><span class="menuIcon lnr lnr-menu"></span>MENU</h3>
    </div>
    <div id="acordiao" class="DB1024">
        <ul>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' ){ ?>
                <li>
                    <a href="/admin/painel"><h3 class="<? if($sep==1){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-home"></span>Painel</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' ){ ?>
                <?if( $tipo_user=='admin' ){ ?>
                <li>
                    <h3 class="<? if($sep==13){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-apartment"></span>Portefólio<span class="menuSeta lnr lnr-chevron-<? if($sep==13){echo "down";}else{echo "right";}?>"></span>
                    </h3>
                    <ul  class="<? if($sep!=13){echo "none";}?>">
                        <li><a href="/admin/portfolios" class="<? if($sub==13.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Fichas de Obra</a></li>
                        <!--<li><a href="/admin/portfolio" class="<? if($sub==13.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova ficha</a></li>-->
                        <li><a href="/admin/portfolio_ordenar" class="<? if($sub==13.7){echo "menuSubSelec";}else{echo "menuSub";}?>">Ordenar fichas</a></li>
                        <li><a href="/admin/categorias" class="<? if($sub==13.3){echo "menuSubSelec";}else{echo "menuSub";}?>">Categorias</a></li>
                        <li><a href="/admin/estados" class="<? if($sub==13.4){echo "menuSubSelec";}else{echo "menuSub";}?>">Estados</a></li>
                        <li><a href="/admin/moedas" class="<? if($sub==13.5){echo "menuSubSelec";}else{echo "menuSub";}?>">Moedas</a></li>
                        <li><a href="/admin/paises" class="<? if($sub==13.6){echo "menuSubSelec";}else{echo "menuSub";}?>">Países</a></li>
                    </ul>
                </li>
                <? }else{ ?>
                <li>
                    <a href="/admin/portfolios"><h3 class="<? if($sep==13){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-apartment"></span>Portfólio</h3>
                    </a>
                </li>
                <? } ?>
                <li>
                    <a href="/admin/fichas"><h3 class="<? if($sep==2){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-license"></span>Fichas</h3>
                    </a>
                </li>
                <?if( $tipo_user=='admin' ){ ?>
                <li>
                    <h3 class="<? if($sep==11){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-book"></span>Notícias<span class="menuSeta lnr lnr-chevron-<? if($sep==11){echo "down";}else{echo "right";}?>"></span>
                    </h3>
                    <ul  class="<? if($sep!=11){echo "none";}?>">
                        <li><a href="/admin/noticias" class="<? if($sub==11.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Notícias</a></li>
                        <!--<li><a href="/admin/proc_noti" class="<? if($sub==11.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Nova notícia</a></li>-->
                        <li><a href="/admin/tipos" class="<? if($sub==11.3){echo "menuSubSelec";}else{echo "menuSub";}?>">Tipo</a></li>
                    </ul>
                </li>
                <? }else{?>
                <li>
                    <a href="/admin/noticias"><h3 class="<? if($sep==11){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-book"></span>Notícias</h3>
                    </a>
                </li>
                <? }?>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' ){ ?>
                <li>
                    <? $num_taf=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_faz='$id_user' AND data!='0000-00-00'"));
                    $num_tra=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_recetor='$id_user' AND data!='0000-00-00'")); 
                    $num_taf_tra=$num_taf+$num_tra; ?>
                    <a href="/admin/tarefas"><h3 class="<? if($sep==4){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-hourglass"></span>Tarefas <? if($num_taf_tra){?><div class="menuNotif"><?echo $num_taf_tra;?></div><?}?></h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' ){ ?>
                <li>
                    <a href="/admin/etapas"><h3 class="<? if($sep==8){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-construction"></span>Etapas</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' ){ ?>
                <li>
                    <a href="/admin/utilizadores"><h3 class="<? if($sep==3){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-users"></span>Utilizadores</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' ){ ?>
                <li>
                    <h3 class="<? if($sep==12){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-earth"></span>Empresas<span class="menuSeta lnr lnr-chevron-<? if($sep==12){echo "down";}else{echo "right";}?>"></span>
                    </h3>
                    <ul  class="<? if($sep!=12){echo "none";}?>">
                        <li><a href="/admin/empresa_paises" class="<? if($sub==12.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Países</a></li>
                        <!--<li><a href="/admin/empresa_pais" class="<? if($sub==12.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Novo país</a></li>-->
                        <li><a href="/admin/empresa_categorias" class="<? if($sub==12.3){echo "menuSubSelec";}else{echo "menuSub";}?>">Categorias</a></li>
                    </ul>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' || $tipo_user=='guest' ){ ?>
                <li>
                    <? $num_msg=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM chat WHERE lido NOT LIKE '%[$id_user]%' AND id_recetor IN('$id_user','0')")); ?>
                    <a href="/admin/chat"><h3 class="<? if($sep==6){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-bubble"></span>Chat <? if($num_msg){?><div class="menuNotif"><?echo $num_msg;?></div><?}?></h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' ){ ?>
                <li>
                    <a href="/admin/subscricoes"><h3 class="<? if($sep==14){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-spell-check"></span>Subcrições</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' || $tipo_user=='guest' ){ ?>
                <li>
                    <a href="/admin/password"><h3 class="<? if($sep==9){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-lock"></span>Password</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' ){ ?>
                <li>
                    <a href="/admin/historico"><h3 class="<? if($sep==5){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-history"></span>Histórico</h3>
                    </a>
                </li>
                <li>
                    <a href="/admin/tutorial"><h3 class="<? if($sep==10){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-thumbs-up"></span>Tutorial</h3>
                    </a>
                </li>
            <? }?>
            <?if( $tipo_user=='admin' || $tipo_user=='head' || $tipo_user=='user' || $tipo_user=='guest' ){ ?>
                <li>
                    <h3 class="<? if($sep==15){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-list"></span>Documentos<span class="menuSeta lnr lnr-chevron-<? if($sep==15){echo "down";}else{echo "right";}?>"></span>
                    </h3>
                    <ul  class="<? if($sep!=15){echo "none";}?>">
                        <li><a href="/admin/qualidades" class="<? if($sub==15.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Qualidade</a></li>
                        <li><a href="/admin/impressos" class="<? if($sub==15.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Todos os impressos</a></li>
                    </ul>
                </li>
            <? }?>
            <!--<?if( $tipo_user=='admin' ){ ?>
                
                <li>
                    <h3 class="<? if($sep==7){echo "menuSelec";}else{echo "menuSeparador";}?>">
                        <span class="menuIcon lnr lnr-cog"></span>Preferências<span class="menuSeta lnr lnr-chevron-<? if($sep==7){echo "down";}else{echo "right";}?>"></span>
                    </h3>
                    <ul  class="<? if($sep!=7){echo "none";}?>">
                        <li><a href="/admin/categorias" class="<? if($sub==7.1){echo "menuSubSelec";}else{echo "menuSub";}?>">Categorias</a></li>
                        <li><a href="/admin/estados" class="<? if($sub==7.2){echo "menuSubSelec";}else{echo "menuSub";}?>">Estados</a></li>
                        <li><a href="/admin/moedas" class="<? if($sub==7.3){echo "menuSubSelec";}else{echo "menuSub";}?>">Moedas</a></li>
                        <li><a href="/admin/paises" class="<? if($sub==7.4){echo "menuSubSelec";}else{echo "menuSub";}?>">Países</a></li>
                    </ul>
                </li>
            <? }?>-->
        </ul>
    </div>
</div>
<script>
$(document).ready(function(){
    $("#acordiao h3").click(function(){
        $("#acordiao ul ul").slideUp();
        if(!$(this).next().is(":visible"))
        {
            $(this).next().slideDown();
        }
    })
    $("#menuSlide h3").click(function(){
        $("#acordiao").slideToggle();
    })
})
</script>