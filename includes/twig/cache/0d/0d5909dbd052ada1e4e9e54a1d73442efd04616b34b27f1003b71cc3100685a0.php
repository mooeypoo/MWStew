<?php

/* modules/ext.extension.js.twig */
class __TwigTemplate_b0e272ec2eb9db778b3e05d8a7357e9cdebfde272e05b364fcec0341a52df7fa extends Twig_Template
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
        echo "( function () {
\t/**
\t * @class mw.";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["lowername"]) ? $context["lowername"] : null), "html", null, true);
        echo "
\t * @singleton
\t */
\tmw.";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["lowername"]) ? $context["lowername"] : null), "html", null, true);
        echo " = {
\t};
}() );";
    }

    public function getTemplateName()
    {
        return "modules/ext.extension.js.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 6,  23 => 3,  19 => 1,);
    }
}
/* ( function () {*/
/* 	/***/
/* 	 * @class mw.{{ lowername }}*/
/* 	 * @singleton*/
/* 	 *//* */
/* 	mw.{{ lowername }} = {*/
/* 	};*/
/* }() );*/
