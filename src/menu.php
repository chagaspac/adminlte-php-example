<?php
include_once("configs/config.php");
$connection = Db::getInstance();
$statement = $connection->prepare('SELECT m.id, m.nome, m.url, m.icon 
	FROM menu m 
	INNER JOIN grupo_menu gm ON gm.menu_id = m.id 
	INNER JOIN usuario u ON u.grupo_id = gm.grupo_id
	where u.id = '.$_SESSION['usuario']['id'].'
	and (url_pai is null or url_pai = \'\') ORDER BY ordem ASC');

$statement->execute();


$_SESSION['menu'] = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MENU</li>
			<?php

			foreach($_SESSION['menu'] as $menu){
				if($menu['url'] != '#'){
					echo '  <li>
					<a href="'.$menu['url'].'">
						<i class="fa '.$menu['icon'].'"></i> <span>'.$menu['nome'].'</span>
					</a>
				</li>';
			}else{
				// $statement = $connection->prepare('SELECT menu.id, menu.nome, menu.url, menu.icon FROM menu INNER JOIN menu_posicao mp ON mp.menu_id = menu.id  WHERE mp.posicao_id = '.$_SESSION['usuario_posicao']['posicao_id'].' AND url_pai = '.$menu['id'].' AND mostrar = \'S\'  ORDER BY ordem ASC');
				$statement = $connection->prepare('SELECT m.id, m.nome, m.url, m.icon 
					FROM menu m 
					INNER JOIN grupo_menu gm ON gm.menu_id = m.id 
					INNER JOIN usuario u ON u.grupo_id = gm.grupo_id
					where u.id = '.$_SESSION['usuario']['id'].'
					and url_pai = '.$menu['id'].' ORDER BY ordem ASC');
				$statement->execute();


				$submenu = $statement->fetchAll(PDO::FETCH_ASSOC);
				echo '  <li class="treeview">
				<a href="#">
					<i class="fa '.$menu['icon'].'"></i> <span>'.$menu['nome'].'</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">';
					if(!empty($submenu )){
						foreach($submenu  as $item){
							echo '<li><a href="'.$item['url'].'"><i class="fa '.$item['icon'].'"></i> '.$item['nome'].'</a></li>';
						}
					}
					echo '</ul>
				</li>';
			}
		}
		?>
	</ul>
</section>
<!-- /.sidebar -->
</aside>
