<?php
	$t_objMTF_ImageComment = new MTF_ImageComment();
	echo("      MTF_Gallery v 0.1a<br />\n");
	echo("      <br />\n");
	echo("      Gallerys:  ". $mtf_gallery->getCountGallerys() ." Stk.<br />\n");
	echo("      Gallerys (nicht angezeigt):  ". $mtf_gallery->getCountGallerysNotShow() ." Stk.<br />\n");
	echo("      Gallerys (angezeigt):  ". $mtf_gallery->getCountGallerysShow() ." Stk.<br />\n");
	echo("      Images: ". $mtf_gallery->getCountImages() ." Stk.<br />\n");
	echo("      Images (nicht angezeigt): ". $mtf_gallery->getCountImagesNotShow() ." Stk.<br />\n");
	echo("      Images (angezeigt): ". $mtf_gallery->getCountImagesShow() ." Stk.<br />\n");
	echo("      Views: ". $mtf_gallery->getCountViews() ."<br />\n");
	echo("      Original size: ". round($mtf_gallery->getCountSizeOriginal()/1024) ." kb (". round(($mtf_gallery->getCountSizeOriginal() / 1024)/1024) ." MB)<br />\n");
	echo("      Resized size: ". round($mtf_gallery->getCountSizeResized()/1024) ." kb (". round(($mtf_gallery->getCountSizeResized() / 1024)/1024) ." MB)<br />\n");
	echo("      Thumb size: ". round($mtf_gallery->getCountSizeThumb()/1024) ." kb (". round(($mtf_gallery->getCountSizeThumb() / 1024)/1024) ." MB)<br />\n");
	echo("      Speicher gesamgt: ". round($mtf_gallery->getCountSizeSum()/1024) ." kb (". round(($mtf_gallery->getCountSizeSum() / 1024)/1024) ." MB)<br />\n");
	echo("      Kommentare gesamt: ". $t_objMTF_ImageComment->getCountComments() ." Stk.<br />\n");
?>
