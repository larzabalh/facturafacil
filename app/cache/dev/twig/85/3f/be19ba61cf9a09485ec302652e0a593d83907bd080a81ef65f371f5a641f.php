<?php

/* @WebProfiler/Profiler/base_js.html.twig */
class __TwigTemplate_853fbe19ba61cf9a09485ec302652e0a593d83907bd080a81ef65f371f5a641f extends Twig_Template
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
        echo "<script>/*<![CDATA[*/
    Sfjs = (function() {
        \"use strict\";

        var noop = function() {},

            profilerStorageKey = 'sf2/profiler/',

            request = function(url, onSuccess, onError, payload, options) {
                var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                options = options || {};
                options.maxTries = options.maxTries || 0;
                xhr.open(options.method || 'GET', url, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function(state) {
                    if (4 !== xhr.readyState) {
                        return null;
                    }

                    if (xhr.status == 404 && options.maxTries > 1) {
                        setTimeout(function(){
                            options.maxTries--;
                            request(url, onSuccess, onError, payload, options);
                        }, 500);

                        return null;
                    }

                    if (200 === xhr.status) {
                        (onSuccess || noop)(xhr);
                    } else {
                        (onError || noop)(xhr);
                    }
                };
                xhr.send(payload || '');
            },

            hasClass = function(el, klass) {
                return el.className.match(new RegExp('\\\\b' + klass + '\\\\b'));
            },

            removeClass = function(el, klass) {
                el.className = el.className.replace(new RegExp('\\\\b' + klass + '\\\\b'), ' ');
            },

            addClass = function(el, klass) {
                if (!hasClass(el, klass)) { el.className += \" \" + klass; }
            },

            getPreference = function(name) {
                if (!window.localStorage) {
                    return null;
                }

                return localStorage.getItem(profilerStorageKey + name);
            },

            setPreference = function(name, value) {
                if (!window.localStorage) {
                    return null;
                }

                localStorage.setItem(profilerStorageKey + name, value);
            };

        return {
            hasClass: hasClass,

            removeClass: removeClass,

            addClass: addClass,

            getPreference: getPreference,

            setPreference: setPreference,

            request: request,

            load: function(selector, url, onSuccess, onError, options) {
                var el = document.getElementById(selector);

                if (el && el.getAttribute('data-sfurl') !== url) {
                    request(
                        url,
                        function(xhr) {
                            el.innerHTML = xhr.responseText;
                            el.setAttribute('data-sfurl', url);
                            removeClass(el, 'loading');
                            (onSuccess || noop)(xhr, el);
                        },
                        function(xhr) { (onError || noop)(xhr, el); },
                        '',
                        options
                    );
                }

                return this;
            },

            toggle: function(selector, elOn, elOff) {
                var i,
                    style,
                    tmp = elOn.style.display,
                    el = document.getElementById(selector);

                elOn.style.display = elOff.style.display;
                elOff.style.display = tmp;

                if (el) {
                    el.style.display = 'none' === tmp ? 'none' : 'block';
                }

                return this;
            }
        }
    })();
/*]]>*/</script>
";
    }

    public function getTemplateName()
    {
        return "@WebProfiler/Profiler/base_js.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  91 => 35,  83 => 30,  75 => 28,  66 => 25,  62 => 24,  50 => 15,  46 => 14,  42 => 12,  32 => 6,  26 => 3,  24 => 2,  19 => 1,  478 => 272,  475 => 271,  439 => 274,  437 => 271,  431 => 267,  421 => 263,  416 => 260,  411 => 259,  401 => 255,  396 => 252,  391 => 251,  381 => 247,  376 => 244,  371 => 243,  361 => 239,  356 => 236,  352 => 235,  348 => 233,  344 => 231,  340 => 229,  338 => 228,  332 => 224,  318 => 213,  304 => 202,  296 => 197,  284 => 188,  276 => 183,  268 => 178,  260 => 173,  252 => 168,  243 => 161,  240 => 160,  228 => 151,  222 => 148,  216 => 145,  206 => 138,  197 => 131,  194 => 130,  192 => 129,  186 => 125,  184 => 124,  177 => 120,  94 => 40,  79 => 29,  73 => 31,  67 => 28,  55 => 22,  49 => 19,  43 => 16,  39 => 15,  35 => 14,  20 => 1,  168 => 75,  150 => 60,  140 => 52,  130 => 48,  125 => 45,  120 => 44,  110 => 40,  105 => 37,  100 => 36,  90 => 39,  85 => 37,  80 => 28,  70 => 26,  65 => 21,  61 => 25,  48 => 9,  45 => 8,  33 => 4,  30 => 5,);
    }
}
