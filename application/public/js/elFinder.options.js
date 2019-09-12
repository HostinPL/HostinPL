/**
 * Default elFinder config
 *
 * @type  Object
 * @autor Dmitry (dio) Levashov
 */
elFinder.prototype._options = {
	/**
	 * Connector url. Required!
	 *
	 * @type String
	 */
	url : '',

	/**
	 * Ajax request type.
	 *
	 * @type String
	 * @default "get"
	 */
	requestType : 'get',

	/**
	 * Transport to send request to backend.
	 * Required for future extensions using websockets/webdav etc.
	 * Must be an object with "send" method.
	 * transport.send must return $.Deferred() object
	 *
	 * @type Object
	 * @default null
	 * @example
	 *  transport : {
	 *    init : function(elfinderInstance) { },
	 *    send : function(options) {
	 *      var dfrd = $.Deferred();
	 *      // connect to backend ...
	 *      return dfrd;
	 *    },
	 *    upload : function(data) {
	 *      var dfrd = $.Deferred();
	 *      // upload ...
	 *      return dfrd;
	 *    }
	 *    
	 *  }
	 **/
	transport : {},

	/**
	 * URL to upload file to.
	 * If not set - connector URL will be used
	 *
	 * @type String
	 * @default  ''
	 */
	urlUpload : '',

	/**
	 * Allow to drag and drop to upload files
	 *
	 * @type Boolean|String
	 * @default  'auto'
	 */
	dragUploadAllow : 'auto',
	
	/**
	 * Timeout for upload using iframe
	 *
	 * @type Number
	 * @default  0 - no timeout
	 */
	iframeTimeout : 0,
	
	/**
	 * Data to append to all requests and to upload files
	 *
	 * @type Object
	 * @default  {}
	 */
	customData : {},
	
	/**
	 * Event listeners to bind on elFinder init
	 *
	 * @type Object
	 * @default  {}
	 */
	handlers : {},

	/**
	 * Interface language
	 *
	 * @type String
	 * @default "en"
	 */
	lang : 'en',

	/**
	 * Additional css class for filemanager node.
	 *
	 * @type String
	 */
	cssClass : '',

	/**
	 * Active commands list
	 * If some required commands will be missed here, elFinder will add its
	 *
	 * @type Array
	 */
	commands : [
		'open', 'reload', 'home', 'up', 'back', 'forward', 'getfile', 'quicklook', 
		'download', 'rm', 'duplicate', 'rename', 'mkdir', 'mkfile', 'upload', 'copy', 
		'cut', 'paste', 'edit', 'extract', 'archive', 'search', 'info', 'view', 'help', 'resize', 'sort', 'netmount'
	],
	
	/**
	 * Commands options.
	 *
	 * @type Object
	 **/
	commandsOptions : {
		// "getfile" command options.
		getfile : {
			onlyURL  : false,
			// allow to return multiple files info
			multiple : false,
			// allow to return filers info
			folders  : false,
			// action after callback (""/"close"/"destroy")
			oncomplete : ''
		},
		// "upload" command options.
		upload : {
			ui : 'uploadbutton'
		},
		// "quicklook" command options.
		quicklook : {
			autoplay : true,
			jplayer  : 'extensions/jplayer'
		},
		// "quicklook" command options.
		edit : {
        editors : [
            {
                // CKEditor for html file
                mimes : ['text/html'],
                exts  : ['htm', 'html', 'xhtml'],
                load : function(textarea) {
                    $('head').append($('<script>').attr('src', '[PATH TO]/ckeditor.js'));
                    return CKEDITOR.replace( textarea.id, {
                        startupFocus : true,
                        fullPage: true,
                        allowedContent: true
                    });
                },
                close : function(textarea, instance) {
                    instance.destroy();
                },
                save : function(textarea, instance) {
                    textarea.value = instance.getData();
                },
                focus : function(textarea, instance) {
                    instance && instance.focus();
                }
            },
            {
                // `mimes` is not set for support everything kind of text file
                load : function(textarea) {
                    if (typeof ace !== 'object') {
                        $('head').append($('<script>').attr('src', '[PATH TO]/ace.js'));
                        $('head').append($('<script>').attr('src', '[PATH TO]/ext-modelist.js'));
                        $('head').append($('<script>').attr('src', '[PATH TO]/ext-settings_menu.js'));
                        $('head').append($('<script>').attr('src', '[PATH TO]/ext-language_tools.js'));
                    }
                    var self = this, editor, editorBase, mode,
                    ta = $(textarea),
                    taBase = ta.parent(),
                    dialog = taBase.parent(),
                    id = textarea.id + '_ace',
                    ext = this.file.name.replace(/^.+\.([^.]+)|(.+)$/, '$1$2').toLowerCase(),
                    mimeMode = {
                        'text/x-php'              : 'php',
                        'application/x-php'       : 'php',
                        'text/html'               : 'html',
                        'application/xhtml+xml'   : 'html',
                        'text/javascript'         : 'javascript',
                        'application/javascript'  : 'javascript',
                        'text/css'                : 'css',
                        'text/x-c'                : 'c_cpp',
                        'text/x-csrc'             : 'c_cpp',
                        'text/x-chdr'             : 'c_cpp',
                        'text/x-c++'              : 'c_cpp',
                        'text/x-c++src'           : 'c_cpp',
                        'text/x-c++hdr'           : 'c_cpp',
                        'text/x-shellscript'      : 'sh',
                        'application/x-csh'       : 'sh',
                        'text/x-python'           : 'python',
                        'text/x-java'             : 'java',
                        'text/x-java-source'      : 'java',
                        'text/x-ruby'             : 'ruby',
                        'text/x-perl'             : 'perl',
                        'application/x-perl'      : 'perl',
                        'text/x-sql'              : 'sql',
                        'text/xml'                : 'xml',
                        'application/docbook+xml' : 'xml',
                        'application/xml'         : 'xml'
                    },
                    resize = function(){
                        dialog.height($(window).height() * 0.9).trigger('posinit');
                        taBase.height(dialog.height() - taBase.prev().outerHeight(true) - taBase.next().outerHeight(true) - 8);
                    };

                    mode = ace.require('ace/ext/modelist').getModeForPath('/' + self.file.name).name;
                    if (mode === 'text') {
                        if (mimeMode[self.file.mime]) {
                            mode = mimeMode[self.file.mime];
                        }
                    }

                    taBase.prev().append(' (' + self.file.mime + ' : ' + mode.split(/[\/\\]/).pop() + ')');

                    $('<div class="ui-dialog-buttonset"/>').css('float', 'left')
                    .append(
                        $('<button>TextArea</button>')
                        .button()
                        .on('click', function(){
                            if (ta.data('ace')) {
                                ta.data('ace', false);
                                editorBase.hide();
                                ta.val(editor.session.getValue()).show().focus();
                                $(this).find('span').text('AceEditor');
                            } else {
                                ta.data('ace', true);
                                editor.setValue(ta.hide().val(), -1);
                                editorBase.show();
                                editor.focus();
                                $(this).find('span').text('TextArea');
                            }
                        })
                    )
                    .append(
                        $('<button>Ace editor setting</button>')
                        .button({
                            icons: {
                                primary: 'ui-icon-gear',
                                secondary: 'ui-icon-triangle-1-e'
                            },
                            text: false
                        })
                        .on('click', function(){
                            editor.showSettingsMenu();
                        })
                    )
                    .prependTo(taBase.next());

                    editorBase = $('<div id="'+id+'" style="width:100%; height:100%;"/>').text(ta.val()).insertBefore(ta.hide());

                    ta.data('ace', true);
                    editor = ace.edit(id);
                    ace.require('ace/ext/settings_menu').init(editor);
                    editor.$blockScrolling = Infinity;
                    editor.setOptions({
                        theme: 'ace/theme/monokai',
                        mode: 'ace/mode/' + mode,
                        wrap: true,
                        enableBasicAutocompletion: true,
                        enableSnippets: true,
                        enableLiveAutocompletion: false
                    });
                    editor.commands.addCommand({
                        name : "saveFile",
                        bindKey: {
                            win : 'Ctrl-s',
                            mac : 'Command-s'
                        },
                        exec: function(editor) {
                            self.doSave();
                        }
                    });
                    editor.commands.addCommand({
                        name : "closeEditor",
                        bindKey: {
                            win : 'Ctrl-w|Ctrl-q',
                            mac : 'Command-w|Command-q'
                        },
                        exec: function(editor) {
                            self.doCancel();
                        }
                    });
                    dialog.on('resize', function(){ editor.resize(); });
                    $(window).on('resize', function(e){
                        if (e.target !== this) return;
                        dialog.data('resizeTimer') && clearTimeout(dialog.data('resizeTimer'));
                        dialog.data('resizeTimer', setTimeout(function(){ resize(); }, 300));
                    });
                    resize();
                    editor.resize();

                    return editor;
                },
                close : function(textarea, instance) {
                    instance.destroy();
                    $(textarea).show();
                },
                save : function(textarea, instance) {
                    if ($(textarea).data('ace')) {
                        $(textarea).val(instance.session.getValue());
                    }
                },
                focus : function(textarea, instance) {
                    instance.focus();
                }
            }
        ]
    },
		// "info" command options.
		info : {nullUrlDirLinkSelf : true},
		

		help : {view : ['about', 'shortcuts', 'help']}
	},
	
	/**
	 * Callback for "getfile" commands.
	 * Required to use elFinder with WYSIWYG editors etc..
	 *
	 * @type Function
	 * @default null (command not active)
	 */
	getFileCallback : null,
	
	/**
	 * Default directory view. icons/list
	 *
	 * @type String
	 * @default "icons"
	 */
	defaultView : 'icons',
	
	/**
	 * UI plugins to load.
	 * Current dir ui and dialogs loads always.
	 * Here set not required plugins as folders tree/toolbar/statusbar etc.
	 *
	 * @type Array
	 * @default ['toolbar', 'tree', 'path', 'stat']
	 * @full ['toolbar', 'places', 'tree', 'path', 'stat']
	 */
	ui : ['toolbar', 'tree', 'path', 'stat'],
	
	/**
	 * Some UI plugins options.
	 * @type Object
	 */
	uiOptions : {
		// toolbar configuration
		toolbar : [
			['back', 'forward'],
			['netmount'],
			// ['reload'],
			// ['home', 'up'],
			['mkdir', 'mkfile', 'upload'],
			['open', 'download', 'getfile'],
			['info'],
			['quicklook'],
			['copy', 'cut', 'paste'],
			['rm'],
			['duplicate', 'rename', 'edit', 'resize'],
			['extract', 'archive'],
			['search'],
			['view', 'sort'],
			['help']
		],
		// directories tree options
		tree : {
			// expand current root on init
			openRootOnLoad : true,
			// auto load current dir parents
			syncTree : true
		},
		// navbar options
		navbar : {
			minWidth : 150,
			maxWidth : 500
		},
		cwd : {
			// display parent folder with ".." name :)
			oldSchool : false
		}
	},

	/**
	 * Display only required files by types
	 *
	 * @type Array
	 * @default []
	 * @example
	 *  onlyMimes : ["image"] - display all images
	 *  onlyMimes : ["image/png", "application/x-shockwave-flash"] - display png and flash
	 */
	onlyMimes : [],

	/**
	 * Custom files sort rules.
	 * All default rules (name/size/kind/date) set in elFinder._sortRules
	 *
	 * @type {Object}
	 * @example
	 * sortRules : {
	 *   name : function(file1, file2) { return file1.name.toLowerCase().localeCompare(file2.name.toLowerCase()); }
	 * }
	 */
	sortRules : {},

	/**
	 * Default sort type.
	 *
	 * @type {String}
	 */
	sortType : 'name',
	
	/**
	 * Default sort order.
	 *
	 * @type {String}
	 * @default "asc"
	 */
	sortOrder : 'asc',
	
	/**
	 * Display folders first?
	 *
	 * @type {Boolean}
	 * @default true
	 */
	sortStickFolders : true,
	
	/**
	 * If true - elFinder will formating dates itself, 
	 * otherwise - backend date will be used.
	 *
	 * @type Boolean
	 */
	clientFormatDate : true,
	
	/**
	 * Show UTC dates.
	 * Required set clientFormatDate to true
	 *
	 * @type Boolean
	 */
	UTCDate : false,
	
	/**
	 * File modification datetime format.
	 * Value from selected language data  is used by default.
	 * Set format here to overwrite it.
	 *
	 * @type String
	 * @default  ""
	 */
	dateFormat : '',
	
	/**
	 * File modification datetime format in form "Yesterday 12:23:01".
	 * Value from selected language data is used by default.
	 * Set format here to overwrite it.
	 * Use $1 for "Today"/"Yesterday" placeholder
	 *
	 * @type String
	 * @default  ""
	 * @example "$1 H:m:i"
	 */
	fancyDateFormat : '',
	
	/**
	 * elFinder width
	 *
	 * @type String|Number
	 * @default  "auto"
	 */
	width : 'auto',
	
	/**
	 * elFinder height
	 *
	 * @type Number
	 * @default  "auto"
	 */
	height : 400,
	
	/**
	 * Make elFinder resizable if jquery ui resizable available
	 *
	 * @type Boolean
	 * @default  true
	 */
	resizable : true,
	
	/**
	 * Timeout before open notifications dialogs
	 *
	 * @type Number
	 * @default  500 (.5 sec)
	 */
	notifyDelay : 500,
	
	/**
	 * Allow shortcuts
	 *
	 * @type Boolean
	 * @default  true
	 */
	allowShortcuts : true,
	
	/**
	 * Remeber last opened dir to open it after reload or in next session
	 *
	 * @type Boolean
	 * @default  true
	 */
	rememberLastDir : true,
	
	/**
	 * Use browser native history with supported browsers
	 *
	 * @type Boolean
	 * @default  true
	 */
	useBrowserHistory : true,
	
	/**
	 * Lazy load config.
	 * How many files display at once?
	 *
	 * @type Number
	 * @default  50
	 */
	showFiles : 30,
	
	/**
	 * Lazy load config.
	 * Distance in px to cwd bottom edge to start display files
	 *
	 * @type Number
	 * @default  50
	 */
	showThreshold : 50,
	
	/**
	 * Additional rule to valid new file name.
	 * By default not allowed empty names or '..'
	 *
	 * @type false|RegExp|function
	 * @default  false
	 * @example
	 *  disable names with spaces:
	 *  validName : /^[^\s]$/
	 */
	validName : false,
	
	/**
	 * Sync content interval
	 * @todo - fix in elFinder
	 * @type Number
	 * @default  0 (do not sync)
	 */
	sync : 0,
	
	/**
	 * How many thumbnails create in one request
	 *
	 * @type Number
	 * @default  5
	 */
	loadTmbs : 5,
	
	/**
	 * Cookie option for browsersdoes not suppot localStorage
	 *
	 * @type Object
	 */
	cookie         : {
		expires : 30,
		domain  : '',
		path    : '/',
		secure  : false
	},
	
	/**
	 * Contextmenu config
	 *
	 * @type Object
	 */
	contextmenu : {
		// navbarfolder menu
		navbar : ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
		// current directory menu
		cwd    : ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'sort', '|', 'info'],
		// current directory file menu
		files  : ['getfile', '|','open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info']
	},

	/**
	 * Debug config
	 *
	 * @type Array|Boolean
	 */
	// debug : true
	debug : ['error', 'warning', 'event-destroy']
}
