'use strict';
module.exports = function( grunt ) {

	// load all tasks
	require( 'load-grunt-tasks' )( grunt, { scope: 'devDependencies' } );

	grunt.config.init( {
		pkg: grunt.file.readJSON( 'package.json' ),

		dirs: {
			css: '/assets/css',
			js: '/assets/js'
		},
		checktextdomain: {
			standard: {
				options: {
					text_domain: [ 'modula-best-grid-gallery' ], //Specify allowed domain(s)
					create_report_file: 'true',
					keywords: [ //List keyword specifications
						'__:1,2d',
						'_e:1,2d',
						'_x:1,2c,3d',
						'esc_html__:1,2d',
						'esc_html_e:1,2d',
						'esc_html_x:1,2c,3d',
						'esc_attr__:1,2d',
						'esc_attr_e:1,2d',
						'esc_attr_x:1,2c,3d',
						'_ex:1,2c,3d',
						'_n:1,2,4d',
						'_nx:1,2,4c,5d',
						'_n_noop:1,2,3d',
						'_nx_noop:1,2,3c,4d'
					]
				},
				files: [
					{
						src: [
							'**/*.php',
							'!**/node_modules/**',
						], //all php
						expand: true
					}
				]
			}
		},
		makepot: {
	        target: {
	            options: {
	                cwd: '',                          // Directory of files to internationalize.
	                domainPath: 'languages/',         // Where to save the POT file.
	                exclude: [],                      // List of files or directories to ignore.
	                include: [],                      // List of files or directories to include.
	                mainFile: 'Modula.php',                     // Main project file.
	                potComments: '',                  // The copyright at the beginning of the POT file.
	                potFilename: 'modula-best-grid-gallery.po',                  // Name of the POT file.
	                potHeaders: {
	                    poedit: true,                 // Includes common Poedit headers.
	                    'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
	                },                                // Headers to add to the generated POT file.
	                processPot: null,                 // A callback function for manipulating the POT file.
	                type: 'wp-plugin',                // Type of project (wp-plugin or wp-theme).
	                updateTimestamp: true,            // Whether the POT-Creation-Date should be updated without other changes.
	                updatePoFiles: false              // Whether to update PO files in the same directory as the POT file.
	            }
	        }
	    },
		cssmin: {
			target: {
				files: [
					{
						expand: true,
						cwd: 'assets/css',
						src: [ '*.css', '!*.min.css' ],
						dest: 'assets/css',
						ext: '.min.css'
					}
				]
			}
		},
		clean: {
			css: [ 'assets/css/*.min.css', '!assets/css/jquery-ui.min.css' ],
			init: {
				src: [ 'build/' ]
			},
			jsmin : {
				src: [
					'assets/js/*.min.js',
					'assets/js/*.min.js.map',
				]
			}
		},
		copy: {
			build: {
				expand: true,
				src: [
					'**',
					'!node_modules/**',
					'!vendor/**',
					'!build/**',
					'!readme.md',
					'!README.md',
					'!phpcs.ruleset.xml',
					'!package-lock.json',
					'!svn-ignore.txt',
					'!Gruntfile.js',
					'!package.json',
					'!composer.json',
					'!composer.lock',
					'!set_tags.sh',
					'!modula-best-grid-gallery.zip',
					'!old/**',
					'!nbproject/**'
				],
				dest: 'build/'
			}
		},

		concat: {
			dist: {
				src : [
					// 'assets/js/lightbox/jquery.event.move.js',
					// 'assets/js/lightbox/jquery.event.swipe.js',
					// 'assets/js/lightbox/jquery-ui.js',
					// 'assets/js/lightbox/hammer.js',
					// 'assets/js/lightbox/jquery.hammer.js',
					'assets/js/lightbox/lightbox.js',
				],
				dest: 'assets/js/lightbox.js'
			},
		},

		uglify: {
			jsfiles: {
				files: [ {
					expand: true,
					cwd   : 'assets/js/',
					src   : [
						'*.js',
						'!*.min.js',
						'!Gruntfile.js',
						'!wp-modula-*.js',
						'!modula-addon.js',
						'!modula-upgrade.js',
						'!wp-modula.js'
					],
					dest  : 'assets/js/',
					ext   : '.min.js'
				} ]
			},
		},

		compress: {
			build: {
				options: {
					pretty: true,                           // Pretty print file sizes when logging.
					archive: '<%= pkg.name %>.zip'
				},
				expand: true,
				cwd: 'build/',
				src: [ '**/*' ],
				dest: '<%= pkg.name %>/'
			}
		},

	} );

	grunt.loadNpmTasks( 'grunt-contrib-clean' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );

	grunt.registerTask( 'textdomain', [
		'checktextdomain',
		'makepot'
	] );
	grunt.registerTask( 'minjs', [  // Minify CSS
		// 'concat',
		'clean:jsmin',
		'uglify'
	] );
	grunt.registerTask( 'mincss', [  // Minify CSS
		'clean:css',
		'cssmin'
	] );
	
	// Build task
	grunt.registerTask( 'build-archive', [
		'clean:init',
		'copy',
		'compress:build',
		'clean:init'
	] );
};