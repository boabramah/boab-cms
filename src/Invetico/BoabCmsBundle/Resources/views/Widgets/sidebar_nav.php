
<div  class="block" id="sidebar-nav">
	<h2>Other Pages</h2>
	<div id="sidebar_menu">
		<div class="menu-list-wrapper">
			<ul>
				<?php foreach($this->menuItems as $menu):?>
			        <li><a href="<?php echo $this->generateUrl($menu);?>"><?php echo $menu->getTitle();?></a></li>
			    <?php endforeach;?>
			</ul>
		</div>
	</div>
	<br class="clear" />
</div>
      