<?php

require_once(
	dirname(__FILE__) . '/../../_lib/tinyTinyFw.php'
);

echo(
	dom( 'table' )
		-> css( array('font-family' => 'Verdana' ) )

		-> append( map( range( 0, 10 ),
						function( $i ) {
							$begin = 33;
							$perRow = 20;

							$x = $begin + ($i * $perRow);

							return(
								dom('tr')
									-> append( dom( 'th', $x ) )
									-> append( map( range( $x, $x + $perRow ),
													function( $j ) {
														// TODO: Find out how to get unicode characters to show up.
														return dom( 'td', chr( $j ) );

													}
										) )
							);
						}
			) )
);

?>