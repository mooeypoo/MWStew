<?php

/* package.json.twig */
class __TwigTemplate_871b22846acc51e6f05082c8ff4488607274c1aaa947d248b0afe73efa2fe09e extends Twig_Template
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
  \"name\": \"";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "\",
  \"version\": \"";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["version"]) ? $context["version"] : null), "html", null, true);
        echo "\",
  \"devDependencies\": {
    \"grunt\": \"0.4.5\",
    \"grunt-cli\": \"0.1.13\",
    \"grunt-contrib-jshint\": \"0.11.3\",
    \"grunt-banana-checker\": \"0.4.0\",
    \"grunt-jscs\": \"2.1.0\",
    \"grunt-jsonlint\": \"1.0.4\"
  }
}";
    }

    public function getTemplateName()
    {
        return "package.json.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 3,  22 => 2,  19 => 1,);
    }
}
/* {*/
/*   "name": "{{ name }}",*/
/*   "version": "{{ version }}",*/
/*   "devDependencies": {*/
/*     "grunt": "0.4.5",*/
/*     "grunt-cli": "0.1.13",*/
/*     "grunt-contrib-jshint": "0.11.3",*/
/*     "grunt-banana-checker": "0.4.0",*/
/*     "grunt-jscs": "2.1.0",*/
/*     "grunt-jsonlint": "1.0.4"*/
/*   }*/
/* }*/
