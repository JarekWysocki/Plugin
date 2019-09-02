<?php

namespace Gregsoft\Theme\Plugins;


class Kolory
{
	
	public
		function __construct()
		{
			//add_filter( 'wp_edit_nav_menu_walker',   array( $this, 'filter_walker'             )        );
			
			
			add_action('admin_menu', array($this, 'add_menu_page'));
			
			// add_action('admin_init', array($this, 'add_options'));
			

			
			add_action( 'admin_init', array($this, 'plugin_admin_init') );

			// add_action( 'admin_enqueue_scripts', array($this, 'addd_cript') );
			// add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );


			add_action('wp_head', array($this, 'kolorki_na_jezorki'), 99);
		}
	

		
	public
		function add_menu_page() 
		{
			add_submenu_page('themes.php', 'Konfiguracja kolorów', 'Konfiguracja kolorów', 'manage_options', 'konfiguracja-kolorow', array($this, 'opcje_kolorow'));
		}
		
		
	public
		function opcje_kolorow() 
		{
			?>
			<div class="wrap">	
			<h1>Konfiguracja kolorów</h1>
			<hr />
			<h2>Możliwość zmiany kolorów </h2>
			<form method="post" action="options.php">
				<?php
					settings_fields("Kolory");
					do_settings_sections("Kolory");  
				?>
				<table style="width: 400px;">
					<tbody>
						<tr>
							<td>
								<p class="submit">
									<input type="submit" name="kolor" class="button button-primary" value="Resetuj wszystko" />
								</p>
							</td>
							<td >
								<div style="display: flex; justify-content: flex-end;">
				<?php
					submit_button(); 
				?>       		</div>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			</div>
			<?
		}
				
	public	
		function plugin_admin_init() {
			// global $my_admin_page;
			// $scr = get_current_screen();
			
			// var_dump($scr);
			
			// header('X-Page-Name: ' . $my_admin_page);

			
			// if($scr -> id == 'gregsoft-theme_page_klienci-loga') {
				register_setting( 'Kolory', 'kolory_settings', array('sanitize_callback' => array($this, 'save_kolory')) );

				add_settings_section(
					'aaa_pluginPage_section', 
					__( '' ), 
					array($this, 'kolory_settings_section_callback'), 
					'Kolory'
				);
				
				
			// }
			// add_action('update_option', array($this, 'save_klienci'));
		}
		
		
	public
		function save_kolory($option)
		{

			if(isset($_POST['kolor']))
			{
				if($_POST['kolor']=='Resetuj wszystko') 
					return '';
				
				
				
				// var_dump($_POST['kolor']);
				$kolor = json_encode($_POST['kolor']);

				
				return $kolor;
				
			}

		}
				
	public
		function kolory_settings_section_callback()
		{
		
			
			
			$kolory = get_option( 'kolory_settings', array() );
			
			if($kolory)
				$kolory = json_decode($kolory, true);
			
						
			// $klienci_encoded = json_decode($klienci);
			$i = 0;
			
			// var_dump($klienci);
			$labels = array('Kolor główny',
							'Kolor dodatkowy',
							'Kolor czcionki',
							'Kolor 4',
							'Kolor 5',
							'Kolor 6',
							'Kolor 7',
							'Kolor 8',
							'Kolor 9',
							'Kolor 10'
			
							);
			?>
			<table id="tablica">
				<thead>
					<tr>
						<th>Lp.</th>
						<th>Kolor</th>
						<th>Kod css</th>
					</tr>
				</thead>
				<tbody>
		
		
			<?php for ($i=0 ; $i<10; $i++) { ?>
				<tr class="logo-klienci">
					<td><?=($i+1); ?>.</td>
					<td>						
						<div class="input-group">
						  <div class="input-group-btn">
							<div class="btn-group">
							  <span title="Wyczyść" class="btn btn-danger dc-color-input-clearer" data-original-title="Empty Field"><i class="wp-menu-image dashicons-before dashicons-no"></i></span>
							</div>
						  </div>
						  <input name="kolor[<?=$i; ?>]" value="<?=isset($kolory[$i]) && $kolory[$i] != '' ? $kolory[$i] : '';?>" placeholder="--color-<?=($i+1);?>" class="form-control pre-input-color" type="text" />
						  <div class="input-group-btn">
							<div class="btn-group">
							  <span title="Przełącz tryb wybierania" class="btn btn-primary dc-color-input-switcher" data-original-title="Switch color picker"><i class="wp-menu-image dashicons-before dashicons-admin-customizer"></i></span>
							</div>
						  </div>
						</div>
						
						
						
						
					</td>
					<td><?=$labels[$i];?></td>
					
					
					
				</tr>

			<?php
			}
  			
			?>	
				</tbody>
			</table>
			
			<br />
			
<hr />



<style>
	.input-group {
		display: flex;
		border-collapse: separate;
	}
	
	.btn {
		display: inline-block;
		padding: 6px 12px;
		margin-bottom: 0;
		font-size: 14px;
		font-weight: 400;
		line-height: 1.42857143;
		text-align: center;
		white-space: nowrap;
		vertical-align: middle;
		-ms-touch-action: manipulation;
		touch-action: manipulation;
		cursor: pointer;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		background-image: none;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	
	.btn-danger {
		color: #fff;
		background-color: #d9534f;
		border-color: #d43f3a;
	}
	.btn-danger:hover {
		color: #fff;
		background-color: #c9302c;
		border-color: #ac2925;
	}
	
	.btn-primary {
		color: #fff;
		background-color: #337ab7;
		border-color: #2e6da4;
	}
	
	.btn-primary:hover {
		color: #fff;
		background-color: #286090;
		border-color: #204d74;
	}
	
	.form-control {
		display: block;
		width: 300px;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		margin: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
		-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	
	.input-group .input-group-btn:first-child .btn{
		border-bottom-right-radius: 0px;
		border-top-right-radius: 0px;
	}
	
	.input-group .input-group-btn:last-child .btn{
		border-bottom-left-radius: 0px;
		border-top-left-radius: 0px;
	}
	
	
</style>
			
			<script>
			$(document).on('click', '.dc-color-input-switcher', function() {
  var dcInputColor = $(this).parent().parent().prev();
  if (dcInputColor.attr('type') == 'text') {
    dcInputColor.attr('type', 'color');
  } else {
    dcInputColor.attr('type', 'text');
  }
});

$(document).on('click', '.dc-color-input-clearer', function() {
  var dcInputColor2 = $(this).parent().parent().next();
  if (dcInputColor2.attr('type') == 'color') {
    dcInputColor2.attr('type', 'text');
  }
  dcInputColor2.val('');
});
			</script>
			<?php
		}
		
	public
		function kolorki_na_jezorki()
		{
			$kolory = get_option( 'kolory_settings', array() );
			
			if($kolory)
			{
				$kolorki = json_decode($kolory, true);
				?>
<style>
:root {
<?php foreach($kolorki as $i => $kolor):
if($kolor != ''): ?>
--color-<?=($i+1); ?>: <?=$kolor; ?>;
<?php 
endif;
endforeach; ?>
}
</style>
				<?php
				
			}
		}
}