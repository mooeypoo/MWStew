/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-jscs' );
	grunt.loadNpmTasks( 'grunt-stylelint' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		less: {
			site: {
				files: {
					'assets/MWStew.css': 'src/less/MWStew.less'
				}
			}
		},
		stylelint: {
			site: {
				options: {
					syntax: 'less'
				},
				src: [
					'src/less/**/*.less'
				]
			}
		},
		cssjanus: {
			options: {
				generateExactDuplicates: true
			},
			site: {
				files: {
					'assets/MWStew.rtl.css': 'assets/MWStew.css'
				}
			}
		},
		banana: {
			all: 'i18n/'
		},
		jshint: {
			options: {
				jshintrc: true
			},
			all: [
				'*.js',
				'src/**/*.js',
				'!node_modules/**'
			]
		},
		jscs: {
			src: [
				'<%= jshint.all %>'
			]
		},
		concat: {
			dist: {
				options: {
					banner: grunt.file.read( 'build/banner.txt' )
				},
				dest: 'assets/MWStew.js',
				src: [
					'src/js/mwstew.init.js'
				]
			}
		}
	} );

	grunt.registerTask( 'default', [ 'lint', 'build' ] );
	grunt.registerTask( 'lint', [ 'stylelint', 'banana', 'jshint', 'jscs' ] );
	grunt.registerTask( 'build', [ 'less', 'cssjanus', 'concat' ] );
};
