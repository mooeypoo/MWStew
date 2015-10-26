<?php

/* i18n/qqq.json.twig */
class __TwigTemplate_6d70e1b1f282ff4b21bd364d52d3da64f77445906ba81d3790feb5612f4a2aad extends Twig_Template
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
        echo "{{";
        echo "desc|name=";
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "|url=";
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo " ";
        echo "}}";
        echo "\"
}";
    }

    public function getTemplateName()
    {
        return "i18n/qqq.json.twig";
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
/* 	"{{ lowername }}-desc": "{{ '{{' }}desc|name={{ name }}|url={{ url }} {{ '}}' }}"*/
/* }*/
