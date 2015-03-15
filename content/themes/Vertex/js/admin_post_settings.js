(function($){
	$(document).ready(function() {
		if ( $( '.et-skill' ).length === 1 ) $( '.et-delete-skill' ).hide();

		$( '.et_vertex_skills_settings' ).sortable( {
			items  : '.et-skill',
			cancel : 'a, input'
		} );

		$( '.et_vertex_skills_settings .et-add-skill' ).click( function() {
			$( '.et-skill:last' ).clone().insertAfter( '.et-skill:last' );

			$( '.et-delete-skill' ).show();

			return false;
		} );

		$('.et_vertex_skills_settings').delegate( '.et-delete-skill', 'click', function() {
			if ( $( '.et-skill' ).length === 1 ) return false;

			$(this).closest( '.et-skill' ).remove();

			if ( $( '.et-skill' ).length === 1 ) $( '.et-delete-skill' ).hide();

			return false;
		} );
	});
})(jQuery)