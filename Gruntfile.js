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
	                potFilename: 'modula-best-grid-gallery.pot',                  // Name of the POT file.
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
						cwd: 'assets/css/front',
						src: [ '*.css', '!*.min.css' ],
						dest: 'assets/css/front',
						ext: '.min.css'
					}
				]
			}
		},
		clean: {
			css: [ 'assets/css/front/*.min.css', '!assets/css/jquery-ui.min.css' ],
			init: {
				src: [ 'build/' ]
			},
			jsmin : {
				src: [
					'assets/js/*.min.js',
					'assets/js/front/*.min.js',
					'assets/js/*.min.js.map',
					'!assets/js/resizesensor.min.js'
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
					'!postcss.config.js',
					'!webpack.config.js',
					'!set_tags.sh',
					'!**.zip',
					'!old/**',
					'!bin/**',
					'!tests/**',
					'!codeception.dist.yml',
					'!regconfig.json',
					'!nbproject/**',
					'!SECURITY.md'
				],
				dest: 'build/'
			}
		},

		concat: {
			css: {
				src : [
					'assets/css/front/fancybox.min.css',
					'assets/css/front/modula.min.css',
				],
				dest: 'assets/css/front.css'
			},js: {
				src : [
					'assets/js/front/isotope.min.js',
					'assets/js/front/isotope-packery.min.js',
					'assets/js/front/justifiedGallery.min.js',
					'assets/js/front/fancybox.min.js',
					'assets/js/front/lazysizes.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-all.js'
			},
			modulawf: {
				src : [
					'assets/js/front/isotope.min.js',
					'assets/js/front/isotope-packery.min.js',
					'assets/js/front/lazysizes.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-wf.js'
			},
			modulawl: {
				src : [
					'assets/js/front/isotope.min.js',
					'assets/js/front/isotope-packery.min.js',
					'assets/js/front/fancybox.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-wl.js'
			},
			modulawlf: {
				src : [
					'assets/js/front/isotope.min.js',
					'assets/js/front/isotope-packery.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-wfl.js'
			},
			modulajwf: {
				src : [
					'assets/js/front/justifiedGallery.min.js',
					'assets/js/front/lazysizes.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-justified-wf.js'
			},
			modulajwl: {
				src : [
					'assets/js/front/justifiedGallery.min.js',
					'assets/js/front/fancybox.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-justified-wl.js'
			},
			modulajwfl: {
				src : [
					'assets/js/front/justifiedGallery.min.js',
					'assets/js/front/jquery-modula.min.js',
				],
				dest: 'assets/js/modula-justified-wfl.js'
			},
		},

		uglify: {
			options: {
		      compress: {
		        global_defs: {
		          'DEBUG': true
		        },
		        dead_code: true
		      }
		    },
			jsfiles: {
				files: [ {
					expand: true,
					cwd   : 'assets/js/front/',
					src   : [
						'*.js',
						'!*.min.js',
						'!Gruntfile.js',
						'!wp-modula-*.js',
						'!modula-addon.js',
						'!modula-upgrade.js',
						'!wp-modula.js',
						'!resizesensor.js'
					],
					dest  : 'assets/js/front/',
					ext   : '.min.js'
				} ]
			}
		},

		compress: {
			build: {
				options: {
					pretty: true,                           // Pretty print file sizes when logging.
					archive: '<%= pkg.name %>-<%= pkg.version %>.zip'
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
		'clean:jsmin',
		'uglify',
		'concat:js',
		'concat:modulawf',
		'concat:modulawl',
		'concat:modulawlf',
		'concat:modulajwf',
		'concat:modulajwl',
		'concat:modulajwfl'
	] );
	grunt.registerTask( 'mincss', [  // Minify CSS
		'clean:css',
		'cssmin',
		'concat:css'
	] );
	
	// Build task
	grunt.registerTask( 'build-archive', [
		'clean:init',
		'copy',
		'compress:build',
		'clean:init'
	] );
};