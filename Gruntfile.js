/* eslint-env node, es6 */

module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );
	grunt.loadNpmTasks( 'grunt-eslint' );
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
					'assets/MWStew.rtl.css': 'assets/MWStew.css',
					'assets/bootstrap.rtl.css': 'assets/bootstrap.min.css'
				}
			}
		},
		banana: {
			all: 'i18n/'
		},
		eslint: {
			options: {
				reportUnusedDisableDirectives: true,
				extensions: [ '.js', '.json' ],
				cache: true
			},
			all: [
				'*.{js,json}',
				'src/**/*.{js,json}',
				'!node_modules/**'
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
	grunt.registerTask( 'lint', [ 'eslint', 'stylelint', 'banana' ] );
	grunt.registerTask( 'build', [ 'less', 'cssjanus', 'concat' ] );
};
