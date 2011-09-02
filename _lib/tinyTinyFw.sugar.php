<?php

class Number {
	var $value = 0;

	function nudge( $value ) {
		$this->value += $value;
		
		return $this;
	}

	function cast( $type ) {
		switch ($type) {
			case 'int':
				return intval($this->value);
			
			default:
				return null;
		}
	}

	function scale( $A ) {
		$scalar = ( $A instanceof Number )
			? $A ->cast( 'int' )
			: $A;

		$this->value *= $scalar;

		return $this;
	}
}

function beSame( $A, $B ) {
	return $A === $B;
}

function number( $A ) {
	if( $A instanceof Number )
		return $A;
	
	$number = new Number();
	$number->value = $A;
	return $number;
}

function scale( $A, $B ) {
	return number( $A ) -> scale( $B );
}

function largest( $array ) {
	return number( max( $array ) );
}

function map( $array, $function ) {
	return array_map( $function, $array );
}

function set( &$var, $value ) {
	$var = $value;
}

?>