<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* modules/custom/user_comment_stats/templates/user-comment-stats-block.html.twig */
class __TwigTemplate_b13882a3584680e8531a3fc48a652003 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "
<div class=\"card mb-4 shadow-sm\">
  <div class=\"card-header bg-primary text-white\">
    <h5 class=\"mb-0\">";
        // line 4
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Estadísticas de comentarios del usuario:"));
        yield " ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["user_name"] ?? null), "html", null, true);
        yield "</h5>
  </div>
  <div class=\"card-body\">
    <p><strong>";
        // line 7
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Comentarios publicados:"));
        yield "</strong> ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["total_comments"] ?? null), "html", null, true);
        yield "</p>
    <p><strong>";
        // line 8
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Total de palabras en comentarios:"));
        yield "</strong> ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["total_word_count"] ?? null), "html", null, true);
        yield "</p>

    ";
        // line 10
        if (($context["recent_comments"] ?? null)) {
            // line 11
            yield "      <h6 class=\"mt-4\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Últimos 5 comentarios"));
            yield "</h6>
      <ul class=\"list-group list-group-flush\">
        ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["recent_comments"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 14
                yield "          <li class=\"list-group-item\">
            <a href=\"";
                // line 15
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "comment_url", [], "any", false, false, true, 15), "html", null, true);
                yield "\" class=\"fw-semibold text-decoration-none\">
              ";
                // line 16
                yield ((CoreExtension::getAttribute($this->env, $this->source, $context["item"], "comment_subject", [], "any", false, false, true, 16)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "comment_subject", [], "any", false, false, true, 16), "html", null, true)) : ("Sin asunto"));
                yield "
            </a>
            <small class=\"text-muted\">
              ";
                // line 19
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("en"));
                yield " <a href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "node_url", [], "any", false, false, true, 19), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "node_title", [], "any", false, false, true, 19), "html", null, true);
                yield "</a>
            </small>
          </li>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            yield "      </ul>
    ";
        } else {
            // line 25
            yield "      <p class=\"text-muted\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("No hay comentarios recientes."));
            yield "</p>
    ";
        }
        // line 27
        yield "  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["user_name", "total_comments", "total_word_count", "recent_comments"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/custom/user_comment_stats/templates/user-comment-stats-block.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  119 => 27,  113 => 25,  109 => 23,  95 => 19,  89 => 16,  85 => 15,  82 => 14,  78 => 13,  72 => 11,  70 => 10,  63 => 8,  57 => 7,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/custom/user_comment_stats/templates/user-comment-stats-block.html.twig", "/var/www/html/web/modules/custom/user_comment_stats/templates/user-comment-stats-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 10, "for" => 13];
        static $filters = ["t" => 4, "escape" => 4];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['t', 'escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
