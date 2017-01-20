window.APT2 = window.APT2 || {};
(function( window, document, $, apt ) {
	'use strict';

    var $document;
    var $id = function( selector ) {
        return $( document.getElementById( selector ) );
    };
    var defaults = {
        idNumber        : false,
        repeatEls       : 'input:not([type="button"],[id^=filelist]),select,textarea,.apt2-media-status',
        styleBreakPoint : 450,
        mediaHandlers   : {},
        media : {
            frames : {}
        }
    };

    var strings = {
        upload_file   : "Use this image",
        upload_files  : "Use these images",
        remove_image  : "Remove Image",
        remove_file   : "Remove",
        file          : "File:",
        download      : "Download",
        check_toggle  : "Select \/ Deselect All"
    };

    apt.metabox = function() {
        if ( apt.$metabox ) {
            return apt.$metabox;
        }
        apt.$metabox = $('.apt2-wrap > .apt2-metabox');
        return apt.$metabox;
    };

    apt.init = function() {
        $document = $( document );
        $('#post').parsley();

        // Setup the APT2 object defaults.
        $.extend( apt, defaults );

        apt.trigger( 'apt_pre_init' );

        var $metabox     = apt.metabox();

        // Make File List drag/drop sortable:
        apt.makeListSortable();

        $metabox
            .on( 'change', '.apt2_upload_file', function() {
                apt.media.field = $( this ).attr( 'id' );
                $id( apt.media.field + '_id' ).val('');
            })
            // Media/file management
            .on( 'click', '.apt2-upload-button', apt.handleMedia )
            .on( 'click', '.apt-attach-list li, .apt2-media-status .img-status img, .apt2-media-status .file-status > span', apt.handleFileClick )
            .on( 'click', '.apt2-remove-file-button', apt.handleRemoveMedia );

        apt.trigger( 'apt_init' );
    };

    apt.handleMedia = function( evt ) {
        evt.preventDefault();

        var $el = $( this );
        apt.attach_id = ! $el.hasClass( 'apt2-upload-list' ) ? $el.closest( '.apt-td' ).find( '.apt2-upload-file-id' ).val() : false;
        // Clean up default 0 value
        apt.attach_id = '0' !== apt.attach_id ? apt.attach_id : false;

        apt._handleMedia( $el.prev('input.apt2-upload-file').attr('id'), $el.hasClass( 'apt2-upload-list' ) );
    };

    apt.handleFileClick = function( evt ) {
        evt.preventDefault();

        var $el    = $( this );
        var $td    = $el.closest( '.apt-td' );
        var isList = $td.find( '.apt2-upload-button' ).hasClass( 'apt2-upload-list' );
        apt.attach_id = isList ? $el.find( 'input[type="hidden"]' ).data( 'id' ) : $td.find( '.apt2-upload-file-id' ).val();

        if ( apt.attach_id ) {
            apt._handleMedia( $td.find( 'input.apt2-upload-file' ).attr('id'), isList, apt.attach_id );
        }
    };

    apt._handleMedia = function( formfield, isList ) {
        if ( ! wp ) {
            return;
        }

        var media         = apt.media;
        media.field       = formfield;
        media.$field      = $id( media.field );
        media.fieldData   = media.$field.data();
        media.previewSize = media.fieldData.previewsize;
        media.fieldName   = media.$field.attr('name');
        media.isList      = isList;

        var uploadStatus, attachment;

        // If this field's media frame already exists, reopen it.
        if ( media.field in media.frames ) {
            media.frames[ media.field ].open();
            return;
        }

        // Create the media frame.
        media.frames[ media.field ] = wp.media( {
            title: apt.metabox().find('label[for="' + media.field + '"]').text(),
            library : media.fieldData.queryargs || {},
            button: {
                text: strings[ isList ? 'upload_files' : 'upload_file' ]
            },
            multiple: isList ? 'add' : false
        } );

        apt.trigger( 'apt_media_modal_init', media );

        apt.mediaHandlers.list = function( selection, returnIt ) {
            // Get all of our selected files
            attachment = selection.toJSON();

            media.$field.val(attachment.url);

            // Setup our fileGroup array
            var fileGroup = [];

            // Setup group to store ID's
            var idGroup = [];

            // Loop through each attachment
            $( attachment ).each( function() {
                if ( this.type && this.type === 'image' ) {
                    var width = media.previewSize[0] ? media.previewSize[0] : 50;
                    var height = media.previewSize[1] ? media.previewSize[1] : 50;

                    // image preview
                    uploadStatus = '<li class="img-status">'+
                        '<img width="'+ width +'" height="'+ height +'" src="' + this.url + '" class="attachment-'+ width +'px'+ height +'px" alt="'+ this.filename +'">'+
                        '<p><a href="#" class="apt2-remove-file-button" rel="'+ media.field +'['+ this.id +']">'+ strings.remove_image +'</a></p>'+
                        '<input type="hidden" id="filelist-'+ this.id +'" data-id="'+ this.id +'" name="'+ media.fieldName +'['+ this.id +']" value="' + this.url + '">'+
                        '</li>';

                }

                // Add our file to our fileGroup array
                fileGroup.push( uploadStatus );

                // Add our ids to our idGroup array
                idGroup.push( this.id );
            });

            var existingValue = $id( media.field +'_id' ).val();

            if ( ! existingValue ) {
                $id( media.field +'_id' ).val( idGroup );
            } else {
                var existingValueArray = existingValue.split(',');
                existingValueArray.push( idGroup );
                $id( media.field +'_id' ).val( existingValueArray );
            }


            if ( ! returnIt ) {
                // Append each item from our fileGroup array to .apt2-media-status
                $( fileGroup ).each( function() {
                    media.$field.siblings('.apt2-media-status').slideDown().append(this);
                });
            } else {
                return fileGroup;
            }

        };

        apt.mediaHandlers.single = function( selection ) {
            // Only get one file from the uploader
            attachment = selection.first().toJSON();

            if ( attachment.type && attachment.type === 'image' ) {

                media.$field.val(attachment.url);
                $id( media.field +'_id' ).val(attachment.id);

                // image preview
                var width = media.previewSize[0] ? media.previewSize[0] : 350;
                uploadStatus = '<div class="img-status"><img width="'+ width +'px" style="max-width: '+ width +'px; width: 100%; height: auto;" src="' + attachment.url + '" alt="'+ attachment.filename +'" title="'+ attachment.filename +'" /><p><a href="#" class="apt2-remove-file-button" rel="' + media.field + '">'+ strings.remove_image +'</a></p></div>';
            } else {
                alert("You can only use a valid image with this field")
            }

            // add/display our output
            media.$field.siblings('.apt2-media-status').slideDown().html(uploadStatus);
        };

        apt.mediaHandlers.selectFile = function() {
            var selection = media.frames[ media.field ].state().get('selection');
            var type = isList ? 'list' : 'single';

            if ( apt.attach_id && isList ) {
                $( '[data-id="'+ apt.attach_id +'"]' ).parents( 'li' ).replaceWith( apt.mediaHandlers.list( selection, true ) );
            } else {
                apt.mediaHandlers[type]( selection );
            }

            apt.trigger( 'apt_media_modal_select', selection, media );
        };

        apt.mediaHandlers.openModal = function() {
            var selection = media.frames[ media.field ].state().get('selection');
            var attach;

            if ( ! apt.attach_id ) {
                selection.reset();
            } else {
                attach = wp.media.attachment( apt.attach_id );
                attach.fetch();
                selection.set( attach ? [ attach ] : [] );
            }

            apt.trigger( 'apt_media_modal_open', selection, media );
        };

        // When a file is selected, run a callback.
        media.frames[ media.field ]
            .on( 'select', apt.mediaHandlers.selectFile )
            .on( 'open', apt.mediaHandlers.openModal );

        // Finally, open the modal
        media.frames[ media.field ].open();
    };

    apt.handleRemoveMedia = function( evt ) {
        evt.preventDefault();
        var $this = $( this );
        if ( $this.is( '.apt-attach-list .apt2-remove-file-button' ) ){
            var relNode = $this.attr('rel').match(/\d+/)[0];
            apt.media.field = $this.attr('rel').match(/[\w_]+/)[0];
            $this.parents('li').remove();
            var node = apt.metabox().find( 'input#' + apt.media.field + '_id' );

            var nodeArray = node.val().split(',');

            var index = nodeArray.indexOf(relNode);

            if (index > -1) {
                nodeArray.splice(index, 1);
                node.val(nodeArray);
            }

            //console.log(relNode);
            return false;
        }

        apt.media.field = $this.attr('rel');

        apt.metabox().find( 'input#' + apt.media.field ).val('');
        apt.metabox().find( 'input#' + apt.media.field + '_id' ).val('');
        $this.parents('.apt2-media-status').html('');

        return false;
    };

    apt.makeListSortable = function() {
        var $filelist = apt.metabox().find( '.apt2-media-status.apt-attach-list' );
        if ( $filelist.length ) {
            $filelist.sortable({ cursor: 'move' }).disableSelection();
        }
    };

    apt.trigger = function( evtName ) {
        var args = Array.prototype.slice.call( arguments, 1 );
        args.push( apt );
        $document.trigger( evtName, args );
    };

    apt.triggerElement = function( $el, evtName ) {
        var args = Array.prototype.slice.call( arguments, 2 );
        args.push( apt );
        $el.trigger( evtName, args );
    };

    $( apt.init );

})(window, document, jQuery, window.APT2);