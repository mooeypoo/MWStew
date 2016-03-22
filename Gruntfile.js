/*jshint node:true */
module.exports = function ( grunt ) {
	grunt.loadNpmTasks( 'grunt-contrib-less' );
	grunt.loadNpmTasks( 'grunt-contrib-csslint' );
	grunt.loadNpmTasks( 'grunt-cssjanus' );

	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),
		less: {
			site: {
				files: {
					'assets/MWStew.css': 'src/less/MWStew.less'
				}
			}
		},
		csslint: {
			options: {
				csslintrc: '.csslintrc'
			},
			site: [
				'assets/MWStew.css'
			],
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
		}
	} );

	grunt.registerTask( 'default', [ 'less', 'csslint', 'cssjanus' ] );
	grunt.registerTask( 'build', [ 'less', 'cssjanus' ] );
};
