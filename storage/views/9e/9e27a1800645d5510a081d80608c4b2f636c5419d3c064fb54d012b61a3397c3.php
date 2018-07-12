<?php

/* email/welcome.twig */
class __TwigTemplate_396792beed12b5b3c813e9993c77fe6121cff3c700dbc72cb79ac960f1d0a616 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "Hi!<br><br>

This is a foxy looking email.<br><br>

Love,<br>
Fox - The Slim framework 3 boilerplate";
    }

    public function getTemplateName()
    {
        return "email/welcome.twig";
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "email/welcome.twig", "/Users/steve/Apps/slim-boilerplate/resources/views/email/welcome.twig");
    }
}
