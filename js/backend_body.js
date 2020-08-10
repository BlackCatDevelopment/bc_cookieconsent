(function($) {
    "use strict";
    $.get(CAT_URL+"/modules/cookieconsent/js/spectrum.js",function() {
        $(".colorselect").spectrum({preferredFormat: "hex", allowEmpty: true, showInput: true });
    });

    $.get(CAT_URL+"/modules/cookieconsent/js/cookieconsent.js",function() {
        $.fn.alterClass = function ( removals, additions ) {
        	var self = this;
        	if ( removals.indexOf( '*' ) === -1 ) {
        		// Use native jQuery methods if there is no wildcard matching
        		self.removeClass( removals );
        		return !additions ? self : self.addClass( additions );
        	}
        	var patt = new RegExp( '\\s' +
        			removals.
        				replace( /\*/g, '[A-Za-z0-9-_]+' ).
        				split( ' ' ).
        				join( '\\s|\\s' ) +
        			'\\s', 'g' );
        	self.each( function ( i, it ) {
        		var cn = ' ' + it.className + ' ';
        		while ( patt.test( cn ) ) {
        			cn = cn.replace( patt, ' ' );
        		}
        		it.className = $.trim( cn );
        	});
        	return !additions ? self : self.addClass( additions );
        }
        function escapeHtml(html) {
            // let the spec decide how to escape the html
            var text = document.createTextNode(html);
            var div = document.createElement('div');
            div.appendChild(text);
            return div.innerHTML;
        }
        function getOptions() {
            var options = {};
            var content = {};
            var palette = {};
            
            options.theme = $("#cc_theme option:selected").val();
            options.position = $("#cc_position option:selected").val();
            options.type = $("#cc_type option:selected").val();

            if($("#cc_content_message").text().length) {
                content.message = $("#cc_content_message").text();
            }
            if($("#cc_content_dismiss").val().length) {
                content.dismiss = $("#cc_content_dismiss").val();
            }
            if($("#cc_content_deny").val().length) {
                content.deny = $("#cc_content_deny").val();
            }
            if($("#cc_content_allow").val().length) {
                content.allow = $("#cc_content_allow").val();
            }
            if($("#cc_content_learn").val().length) {
                content.link = $("#cc_content_learn").val();
            }

            if($("#cc_palette option:selected").val()=="none") {
                palette.popup = {};
                palette.button = {};
                if($("#cc_popup_background").val().length) {
                    palette.popup.background = $("#cc_popup_background").val();
                }
                if($("#cc_popup_text").val().length) {
                    palette.popup.text = $("#cc_popup_text").val();
                }
                if($("#cc_popup_link").val().length) {
                    palette.popup.link = $("#cc_popup_link").val();
                }
                if($("#cc_button_background").val().length) {
                    palette.button.background = $("#cc_button_background").val();
                }
                if($("#cc_button_text").val().length) {
                    palette.button.text = $("#cc_button_text").val();
                }
                if($("#cc_button_border").val().length) {
                    palette.button.border = $("#cc_button_border").val();
                }
            }

            if(typeof palette.popup != 'undefined' && !Object.keys(palette.popup).length) {
                delete palette.popup;
            }
            if(typeof palette.button != 'undefined') {
                if(!Object.keys(palette.button).length) {
                    delete palette.button;
                } else {
                    if(!palette.button.hasOwnProperty("background")) {
                        palette.button.background = 'transparent';
                    }
                }
            }

            options.content = content;
            options.palette = palette;
            return options;
        }

        function updatePreview(target) {
            var opt = getOptions();
            var json = JSON.stringify(opt, null, 2);
            var code = 'var p;\nif(typeof p != "undefined" ) { p.destroy(); }\n';
            $("script#code").replaceWith('<scr'+'ipt type="text/javascript" id="code">\n'+escapeHtml(code + 'window.cookieconsent.initialise(' + json + ', function (popup) {p = popup;});')+ '\n' + '</scr'+'ipt>\n');
            $(".cc-window")
                .alterClass('cc-palette-*','')
                .addClass("cc-palette-"+$("#cc_palette option:selected").val());
            if($("#cc_palette option:selected").val()=="none") {
                $("#cc-own-colors").show();
            } else {
                $("#cc-own-colors").hide();
            }
        }

        $("#cc_palette,#cc_theme,#cc_type,#cc_position").on('change',function(event) {
            updatePreview(event.target);
        });
        $("#cc_popup_background,#cc_popup_link,#cc_popup_text,#cc_button_background,#cc_button_border,#cc_button_text").on('change',function(event) {
            updatePreview(event.target);
        });

        updatePreview();
    });
})(jQuery);

