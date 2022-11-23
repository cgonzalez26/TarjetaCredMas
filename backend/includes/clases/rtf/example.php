<?
	/* $Id: example.php,v0.1 2006/11/30	17:00:00 CET michele@xtnet.it */

	require("class.rtf.php");

	$RTF = new RTF();
	$RTF->set_default_font("Tahoma", 10);

	function draw_title($title, $align = 'right')
	{
		global $RTF;

		$RTF->set_font("Arial Black", 15);
		$TITLE = $RTF->bold(1) . $RTF->underline(1) . $title . $RTF->underline(0) . $RTF->bold(0);
		$RTF->new_line();
		$RTF->add_text($TITLE, $align);
		$RTF->new_line();
		$RTF->new_line();
	}

	draw_title("Graphical Effects");

	$text[] = $RTF->emboss(1). "emboss()". $RTF->emboss(0);
	$text[] = $RTF->sub(1). "sub()". $RTF->sub(0);
	$text[] = $RTF->super(1). "super()". $RTF->super(0);
	$text[] = $RTF->engrave(1) . "engrave()". $RTF->engrave(0);
	$text[] = $RTF->caps(1). "caps()". $RTF->caps(0);
	$text[] = $RTF->outline(1). "outline()" . $RTF->outline(0);
	$text[] = $RTF->shadow(1). "shadow()". $RTF->shadow(0);
	$text[] = $RTF->bold(1). "bold()". $RTF->bold(0);
	$text[] = $RTF->underline(1) . "underline()" . $RTF->underline(0);
	$text[] = $RTF->italic(1). "italic()" . $RTF->italic(0);

	foreach ($text as $key => $value)
	{
		$RTF->add_text($value);
		$RTF->new_line();
	}

	draw_title("Color Examples");

	for ($i=0; $i<17; $i++)
	{
		$RTF->add_text( $RTF->color($i) . "THIS IS A COLORED TEXT (COLOR ID: $i)");
		$RTF->new_line();
	}

	draw_title("Fonts Examples");

	$fonts = Array("Arial", "Arial Black", "Tahoma", "Verdana", "Times New Roman", "Courier New");

	foreach ($fonts as $key => $value)
	{
		$dim = 20;
		$RTF->set_font($value, $dim);
		$RTF->add_text("Written using font ". $RTF->bold(1) . "$value" . $RTF->bold(0) . " with dimension $dim");
		$RTF->new_line();
	}

	$RTF->new_page();
	
	$RTF->add_text($RTF->bold(1) . "NOTE: " . $RTF->bold(0) );
	$RTF->add_text("The page has been changed!");
	$RTF->new_line(2);

	draw_title("Images Examples");
	$img_dim = 200;
	$RTF->add_text("Image aligned to the left");
	$RTF->paragraph();
	$RTF->add_image("prova.jpg", $img_dim, "left");
	$RTF->new_line();
	
	$RTF->add_text("Image aligned to center");
   $RTF->paragraph();
   $RTF->add_image("prova.jpg", $img_dim, "center");
   $RTF->new_line();

	$RTF->add_text("Immage aligned to the right");
   $RTF->paragraph();
   $RTF->add_image("prova.jpg", $img_dim, "right");
   $RTF->new_line();

	$RTF->new_page();
	draw_title("Lists");
	$elenco = array("one", "two", "three", "four", "five");
	$RTF->add_list($elenco,"left");

	$RTF->display();
?>
