<html>
<head>
<link rel="stylesheet" href="system/NX_library/editor/css/<?= $this->NX_css_set();?>.css">
<style>
	div#nextEditor__<?= $this->NX_posittion;?>{
		margin:0 auto;
		width:<?= $this->NX_width;?>;
		position:relative;
	}

	div#theNext_div, div#theNext_div_bottom{
		background:<?= $this->NX_background;?>;
		width:<?= $this->NX_width;?>;
		border:1px solid <?= $this->NX_border;?>;
	}
	
	div#richTextArea{
		border:1px solid <?= $this->NX_border;?>;
		height:<?= $this->NX_height;?>;
		background:<?= $this->NX_body_color;?>;
	}
	#<?= $this->NX_id;?>{
		display:none !important;
	}
	div#theNext_div > button, div#theNext_div_bottom > button {
		width: 25px;
		
	}
</style>

<script>
var editorId = '<?= $this->NX_id;?>';
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body id="NX_body">	
	<div id="nextEditor__<?= $this->NX_posittion;?>" class="<?= $this->NX_class;?>">
		<div id="theNext_div">
			
			<?= $this->NX_font_basic();?>

			<?= $this->NX_list();?>
	
			<?= $this->NX_link();?>
			
			<?= $this->NX_undo();?>
			
			
		</div>
		
		<div id="richTextArea">
			<iframe id="theNEXTeditor" name="theNEXTeditor" frameborder="0"></iframe>
		</div>
		<div class="total_word_count">
			<span id="total_count" style="font-size:11px;"></span>
		</div>	
	</div>

<script type="text/javascript" src="system/NX_library/editor/script/<?= $this->NX_script_set();?>.js"></script>
</body>
</html>


