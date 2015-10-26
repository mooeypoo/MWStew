<?php

/* extension.twig */
class __TwigTemplate_57d1ef9a4e99b5c752f2da95087c621beff47c614b03586c02624d4b6c5f8489 extends Twig_Template
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
        echo "<?php
/**
 *
 * @file
 * @ingroup Extensions
 * @author ";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["author"]) ? $context["author"] : null), "html", null, true);
        echo "
 * @licence ";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["license"]) ? $context["license"] : null), "html", null, true);
        echo "
 */

// Alert the user that this is not a valid entry point to MediaWiki
// if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
\techo <<<EOT
To install this extension, put the following line in LocalSettings.php:
require_once( \"\$IP/extensions/";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "/";
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo ".php\" );
EOT;
   exit( 1 );
}

// Extension credits that will show up on Special:Version
\$wgExtensionCredits['specialpage'][] = array(
   'path' => __FILE__,
   'name' => '";
        // line 23
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "',
   'url' => '";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo "',
   'author' => '";
        // line 25
        echo twig_escape_filter($this->env, (isset($context["author"]) ? $context["author"] : null), "html", null, true);
        echo "',
   'descriptionmsg' => '";
        // line 26
        echo twig_escape_filter($this->env, (isset($context["lowername"]) ? $context["lowername"] : null), "html", null, true);
        echo "-desc',
   'license-name' => '";
        // line 27
        echo twig_escape_filter($this->env, (isset($context["license"]) ? $context["license"] : null), "html", null, true);
        echo "',
);";
    }

    public function getTemplateName()
    {
        return "extension.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 27,  66 => 26,  62 => 25,  58 => 24,  54 => 23,  41 => 15,  30 => 7,  26 => 6,  19 => 1,);
    }
}
/* <?php*/
/* /***/
/*  **/
/*  * @file*/
/*  * @ingroup Extensions*/
/*  * @author {{ author }}*/
/*  * @licence {{ license }}*/
/*  *//* */
/* */
/* // Alert the user that this is not a valid entry point to MediaWiki*/
/* // if they try to access the special pages file directly.*/
/* if ( !defined( 'MEDIAWIKI' ) ) {*/
/* 	echo <<<EOT*/
/* To install this extension, put the following line in LocalSettings.php:*/
/* require_once( "$IP/extensions/{{ name }}/{{ name }}.php" );*/
/* EOT;*/
/*    exit( 1 );*/
/* }*/
/* */
/* // Extension credits that will show up on Special:Version*/
/* $wgExtensionCredits['specialpage'][] = array(*/
/*    'path' => __FILE__,*/
/*    'name' => '{{ name }}',*/
/*    'url' => '{{ url }}',*/
/*    'author' => '{{ author }}',*/
/*    'descriptionmsg' => '{{ lowername }}-desc',*/
/*    'license-name' => '{{ license }}',*/
/* );*/
