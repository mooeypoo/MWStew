<?php

/* Gruntfile.js.twig */
class __TwigTemplate_9dd3d9b6f66e56c51da42477336ac493136e9094f8be4b10434cb79a85f926b8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "/*jshint node:true */
module.exports = function ( grunt ) {
\tgrunt.loadNpmTasks( 'grunt-contrib-jshint' );
\tgrunt.loadNpmTasks( 'grunt-jsonlint' );
\tgrunt.loadNpmTasks( 'grunt-banana-checker' );
\tgrunt.loadNpmTasks( 'grunt-jscs' );

\tgrunt.initConfig( {
\t\tjshint: {
\t\t\toptions: {
\t\t\t\tjshintrc: true
\t\t\t},
\t\t\tall: [
\t\t\t\t'*.js',
\t\t\t\t'modules/**/*.js'
\t\t\t]
\t\t},
\t\tjscs: {
\t\t\tsrc: '<%= jshint.all %>'
\t\t},
\t\tbanana: {
\t\t\tall: 'i18n/'
\t\t},
\t\tjsonlint: {
\t\t\tall: [
\t\t\t\t'*.json',
\t\t\t\t'**/*.json',
\t\t\t\t'!node_modules/**'
\t\t\t]
\t\t}
\t} );

\tgrunt.registerTask( 'test', [ 'jshint', 'jscs', 'jsonlint', 'banana' ] );
\tgrunt.registerTask( 'default', 'test' );
};";
    }

    public function getTemplateName()
    {
        return "Gruntfile.js.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
/* /*jshint node:true *//* */
/* module.exports = function ( grunt ) {*/
/* 	grunt.loadNpmTasks( 'grunt-contrib-jshint' );*/
/* 	grunt.loadNpmTasks( 'grunt-jsonlint' );*/
/* 	grunt.loadNpmTasks( 'grunt-banana-checker' );*/
/* 	grunt.loadNpmTasks( 'grunt-jscs' );*/
/* */
/* 	grunt.initConfig( {*/
/* 		jshint: {*/
/* 			options: {*/
/* 				jshintrc: true*/
/* 			},*/
/* 			all: [*/
/* 				'*.js',*/
/* 				'modules/**//* *.js'*/
/* 			]*/
/* 		},*/
/* 		jscs: {*/
/* 			src: '<%= jshint.all %>'*/
/* 		},*/
/* 		banana: {*/
/* 			all: 'i18n/'*/
/* 		},*/
/* 		jsonlint: {*/
/* 			all: [*/
/* 				'*.json',*/
/* 				'**//* *.json',*/
/* 				'!node_modules/**'*/
/* 			]*/
/* 		}*/
/* 	} );*/
/* */
/* 	grunt.registerTask( 'test', [ 'jshint', 'jscs', 'jsonlint', 'banana' ] );*/
/* 	grunt.registerTask( 'default', 'test' );*/
/* };*/
