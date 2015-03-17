<?php
/**
 * The template for displaying the footer.
  *
  * Contains the closing of the id=main div and all content after
  *
  * @package  WordPress
  * @file     footer.php
  * @author   FairPixels
  * @link 	 http://fairpixels.com
  */
?>
		</div><!-- /content-wrap -->
        	</div><!-- /main -->
            
        				<div id="pi">
                	<div class="pia">
                    </div>
                    <div class="piab">
                    </div>
                </div>
                <div id="pc">
                	<span id="pt">PUBLICIDAD</span>
                </div>
                <div id="pd">
                	<div class="pia">
                    </div>
                    <div class="piab">
                    </div>
                </div>
                        </div>
                        		
        <div id="pubCont" style="width:95%; height:100%; overflow:hidden; position:relative; left:2%;">
		<div id="allM" style="width:100%; height:100%;">
                <div style="position:relative; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/02_ABM.jpg" height="95%">
                </img>
                </div>
    
                <div style="position:relative; top:-100%; left:34%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/06_MEXICO.jpg" height="95%">
                </div>
                
                <div style="position:relative; top:-200%; left:68%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/05_FARMACIAS_GUADALAJARA.jpg" height="95%">
                </div>
                
                <div style="position:relative; top:-300%; left:102%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/02_ABM.jpg" height="95%">
                </img>
                </div>
    
                <div style="position:relative; top:-400%; left:136%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/06_MEXICO.jpg" height="95%">
                </div>
                
                <div style="position:relative; top:-500%; left:170%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/05_FARMACIAS_GUADALAJARA.jpg" height="95%">
                </div>
                
                
                <div style="position:relative; top:-600%; left:206%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/02_ABM.jpg" height="95%">
                </img>
                </div>
    
                <div style="position:relative; top:-700%; left:240%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/06_MEXICO.jpg" height="95%">
                </div>
                
                <div style="position:relative; top:-800%; left:272%; height:100%;">
                    <img src="http://www.multimediacorp.net/concanaco/wp-content/uploads/2014/11/05_FARMACIAS_GUADALAJARA.jpg" height="95%">
                </div>
                
        </div>
        </div>
        
        <div id="navs">
        <div id="navLeft" class="mm">
            <div style="width:100%; height:100%;">
                <img style="position:relative; top:40%;" src="images/Left.png" width="100%"/>
            </div>
        </div>
        
        <div id="navRight" class="mm">
            <div style="width:100%; height:100%;">
                <img style="position:relative; top:40%;" src="images/Right.png" width="100%"/>
            </div>
        </div>
        </div>
                </div>
        	<script type="text/javascript">
		var $j = jQuery.noConflict();
		$j( document ).ready(function() {
		  // Handler for .ready() called.
		  var count = 0;
		
			$j("#navLeft").click(function() {
				//$j('#footerInfo').html($j('#allM').css('left'));
				if($j('#allM').css('left') != 'auto' & $j('#allM').css('left') != '0px')
					anima("+");
			});
			
			$j("#navRight").click(function() {
				//$j('#footerInfo').html($j('#allM').css('left'));
				if($j('#allM').css('left') != '-1065.890625px')
					anima("-");
			});
			
			function anima(s)
			{
				//if(anim)
				//{
					$j('#allM').animate({
						left:  s +"=34%"
					  }, 800, function() {
						// Animation complete.
						if(count == 3)
						{
						$j('#allM').animate({
							left:  0
						  }, 0, function() {
							// Animation complete.
							//$('#espacio').html($('#allM').css('left'));
							count = 0;
						  });
						}
					  });
				//}
			}
			
			$j(".mm").mouseover(function() {
				$j(".mm").css( 'cursor', 'pointer' );
			});
			
			$j(".mm").mouseout(function() {
			});
			
			setInterval(function () {
				if(count < 3)
				{
					count++;
					anima("-");
					
				}
				else
				{
					
				}
				}, 3000);
		});
	
	/**/
		</script>
        </div>
	<div id="footerInfo">
        	<div id="footerTop">
                	<div id="topLeftLeft">
                        </div>
                    	<div id="topLeft">
                        	<ul id="ulTopLeft">
                                	<li class="concaTit">CONCANACO SERVYTUR</li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                        <li class="sig">Siguenos:</li>
                                        <li class="socI"><a href="./?p=498"><img src="images/face.png" width="2%"/></a></li>
                                        <li class="socI"><a href="#"><img src="images/twit.png" width="2%"/></a></li>
                                        <li class="socI"><a href="#"><img src="images/puntos.png" width="2%"/></a></li>
                                        <li class="socI"><a href="#"><img src="images/you.png" width="2%"/></a></li>
                                        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                                        <li class="newsL">NEWSLETTER</li>
                                    </ul>
                            </div>
                        <div id="topRight">
                <a href="#" onclick="window.scrollBy(0,0);">
                    <div id="bInicio">
                        <div id="tIni">
                            <img src="images/up.png" width="15%" style="margin-top:6px;"/>
                        </div>
                        <div id="tBa">
                            inicio
                        </div>
                    </div>
                </a>
            </div>
                    </div>
                <div id="footerMed">
                	<div id="mLeft">
                        </div>
                    	<div id="mMed">
                        	<div id="med1">
                                </div>
                                <div id="med2">
                                	<div id="medio1" style="border-right:1px solid #C00;" class="enMedio">
                                        	<?php echo do_shortcode('[do_widget id="nav_menu-2"]');?>
                                            </div>
                                        <div id="medio2" style="border-right:1px solid #C00;" class="enMedio">
                                        	<?php echo do_shortcode('[do_widget id="nav_menu-3"]');?>
                                            </div>
                                        <div id="medio3" style="border-right:1px solid #C00;" class="enMedio">
                                        	<?php echo do_shortcode('[do_widget id="nav_menu-4"]');?>
                                            </div>
                                        <div id="medio4" style="border-right:1px solid #C00;" class="enMedio">
                                        	<?php echo do_shortcode('[do_widget id="nav_menu-5"]');?>
                                            </div>
                                        <div id="medio5" style="border-right:1px solid #C00;" class="enMedio">
                                        	<?php echo do_shortcode('[do_widget id="nav_menu-6"]');?>
                                            </div>
                                        <div id="medio6" class="enMedio">
                                        	<div id="topMedio6">
                                                	<?php echo do_shortcode('[do_widget id="nav_menu-7"]');?>
                                                    </div>
                                                <div id="botMedio6">
                                                <div id="appsIcons">
                                                	<a href="#"><img src="images/apple.png" class="appIcon"/></a>
                                                        &nbsp;
                                                        <a href="#"><img src="images/android.png" class="appIcon"/></a>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                <div id="med3">
                                </div>
                                                        <div id="mRight">
                        </div>
                    </div>
        		<div id="footerBot">
                	<ul id="ulBotFooter">
                            	<li class="concaTitBot">contacto@concanaco.com.mx</li>
                                        <li class="sig">2015 Concanaco Servytur México.	DERECHOS RESERVADOS</li>
                                        <li><a href="#">AVISO DE PRIVACIDAD</a></li>
                                    </ul>
                        </div>
            </div>
    </div><!-- /container -->
    <?php wp_footer(); ?>
</body>
<script type="text/javascript">
    	//alert(window.innerWidth);
        </script>
</html>