<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_WARNING);

require_once dirname(__FILE__) . '/../../_lib/tinyTinyFw.php';

set( Dom::$widgets['widget:toggleButton'],
	function($dom) {
		$states = $dom->getConfig('states');

		$size = 10;

		$width = scale(
					scale( $size, 0.5 ),
					largest(
						map(
							$states,
							
							function( $str ) {
								return mb_strlen($str);
							}
						)
					) -> nudge( 4 )
				) -> cast( 'int' );

		$close = beSame(
					'close',
					$dom -> getConfig('type')
				);

		$normalBg = ( $close )
						? 'hsl(0,30%,40%)'
						: 'hsl(200,30%,35%)';

		$normalBorder = ( $close )
							? 'solid 2px hsl(200,40%,80%)'
							: 'solid 2px hsl(200,40%,35%)';

		$hoverBorder = 'solid 2px hsl(50,80%,80%)';

		return( dom( 'a' )
					-> jsCall( 'toggler', array(
								'states' => $states,
								'currentIndex' => 0 
							) )

					-> attr( 'data-widget', 'toggleButton' )
					
					-> attr( 'onmouseover', "this.style.border = '$hoverBorder'; this.style.letterSpacing = '1px';" )
					
					-> attr( 'onmouseout', "this.style.border = '$normalBorder'; this.style.letterSpacing = '2px';" )
					
					-> css( array(
							'width' => "{$width}px",
							'cursor' => "default",
							'-webkit-border-radius' => $close ? '0 8px 0 20px' : '4px 4px 0 0',
							'display' => 'inline-block',
							'vertical-align' => 'text-top',
							'letter-spacing' => '2px',
							'text-align' => 'center',
							'font-size' => "{$size}px",
							'padding' => $close ? '2px 0px 4px 4px' : '2px 0',
							'border' => $normalBorder,
							'color' => $close ? 'hsl(200,40%,85%)' : 'hsl(200,40%,80%)',
							'margin' => $close ? '1px' : '0 8px',
							'background' => $normalBg
						) )
		);
	}
);

set( Dom::$widgets['widget:window'],
	function($dom) {
		return(
			dom('div')
				-> css( array(
						'position' => 'relative',
						'-webkit-border-radius' => '8px',
						'border-bottom' => 'solid 2px hsl(200,35%,55%)',
						'background' => 'hsl(200,35%,75%)',
						'padding' => '0',
						'overflow' => 'hidden'
					) )

				-> append(
						dom('div')
							-> css( array(
									'float' => 'right',
									'margin' => '0',
									'padding' => '0'
								) )

							-> append(
									dom( 'widget:toggleButton' )
										-> setConfig( 'states', array( 'Close' ) )
										-> setConfig( 'type', 'close' )
								),

						dom( 'div' )
							-> css( array(
									'position' => 'absolute',
									'right' => '0',
									'bottom' => '0',
									'margin' => '0',
									'padding' => '0'
								) )

							-> append(
									dom( 'widget:toggleButton' )
										-> setConfig( 'states', array( 'Fullscreen', 'Inline' ) )
								),

						dom( 'div' )
							-> css( array(
									'padding' => '1em',
									'padding-bottom' => '10em'
								) )

							-> append( $dom -> getConfig( 'content' ) )
				)
		);
	}
);

echo(
	Dom::render(
		dom( 'widget:window' ) -> setConfig( 'content', '12345' )
	)
);

?>