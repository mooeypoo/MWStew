<?php

/* i18n/en.json.twig */
class __TwigTemplate_5391bd5e4cd23b155c4dcb28a3399440e578941e498ecf7e67e9f83954ec2810 extends Twig_Template
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
        echo "{
\t\"";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["lowername"]) ? $context["lowername"] : null), "html", null, true);
        echo "-desc\": \"";
        echo twig_escape_filter($this->env, (isset($context["desc"]) ? $context["desc"] : null), "html", null, true);
        echo "\"
}";
    }

    public function getTemplateName()
    {
        return "i18n/en.json.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 2,  19 => 1,);
    }
}
/* {*/
/* 	"{{ lowername }}-desc": "{{ desc }}"*/
/* }*/
