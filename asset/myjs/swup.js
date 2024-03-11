/*Enabled AJAX Custom SWUP Plugin*/
!(function (e, t) {
  "object" == typeof exports && "object" == typeof module
    ? (module.exports = t())
    : "function" == typeof define && define.amd
    ? define([], t)
    : "object" == typeof exports
    ? (exports.Swup = t())
    : (e.Swup = t());
})(window, function () {
  return (function (e) {
    var t = {};
    function n(i) {
      if (t[i]) return t[i].exports;
      var r = (t[i] = { i: i, l: !1, exports: {} });
      return e[i].call(r.exports, r, r.exports, n), (r.l = !0), r.exports;
    }
    return (
      (n.m = e),
      (n.c = t),
      (n.d = function (e, t, i) {
        n.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: i });
      }),
      (n.r = function (e) {
        "undefined" != typeof Symbol &&
          Symbol.toStringTag &&
          Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }),
          Object.defineProperty(e, "__esModule", { value: !0 });
      }),
      (n.t = function (e, t) {
        if ((1 & t && (e = n(e)), 8 & t)) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var i = Object.create(null);
        if (
          (n.r(i),
          Object.defineProperty(i, "default", { enumerable: !0, value: e }),
          2 & t && "string" != typeof e)
        )
          for (var r in e)
            n.d(
              i,
              r,
              function (t) {
                return e[t];
              }.bind(null, r)
            );
        return i;
      }),
      (n.n = function (e) {
        var t =
          e && e.__esModule
            ? function () {
                return e.default;
              }
            : function () {
                return e;
              };
        return n.d(t, "a", t), t;
      }),
      (n.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t);
      }),
      (n.p = ""),
      n((n.s = 2))
    );
  })([
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.Link =
          t.markSwupElements =
          t.getCurrentUrl =
          t.transitionEnd =
          t.fetch =
          t.getDataFromHtml =
          t.createHistoryRecord =
          t.classify =
            void 0);
      var i = d(n(8)),
        r = d(n(9)),
        o = d(n(10)),
        a = d(n(11)),
        s = d(n(12)),
        u = d(n(13)),
        l = d(n(14)),
        c = d(n(15));
      function d(e) {
        return e && e.__esModule ? e : { default: e };
      }
      (t.classify = i.default),
        (t.createHistoryRecord = r.default),
        (t.getDataFromHtml = o.default),
        (t.fetch = a.default),
        (t.transitionEnd = s.default),
        (t.getCurrentUrl = u.default),
        (t.markSwupElements = l.default),
        (t.Link = c.default);
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.query = function (e) {
          var t =
            arguments.length > 1 && void 0 !== arguments[1]
              ? arguments[1]
              : document;
          return "string" != typeof e ? e : t.querySelector(e);
        }),
        (t.queryAll = function (e) {
          var t =
            arguments.length > 1 && void 0 !== arguments[1]
              ? arguments[1]
              : document;
          return "string" != typeof e
            ? e
            : Array.prototype.slice.call(t.querySelectorAll(e));
        });
    },
    function (e, t, n) {
      "use strict";
      var i,
        r = (i = n(3)) && i.__esModule ? i : { default: i };
      e.exports = r.default;
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i =
          Object.assign ||
          function (e) {
            for (var t = 1; t < arguments.length; t++) {
              var n = arguments[t];
              for (var i in n)
                Object.prototype.hasOwnProperty.call(n, i) && (e[i] = n[i]);
            }
            return e;
          },
        r = (function () {
          function e(e, t) {
            for (var n = 0; n < t.length; n++) {
              var i = t[n];
              (i.enumerable = i.enumerable || !1),
                (i.configurable = !0),
                "value" in i && (i.writable = !0),
                Object.defineProperty(e, i.key, i);
            }
          }
          return function (t, n, i) {
            return n && e(t.prototype, n), i && e(t, i), t;
          };
        })(),
        o = y(n(4)),
        a = y(n(6)),
        s = y(n(7)),
        u = y(n(16)),
        l = y(n(17)),
        c = y(n(18)),
        d = y(n(19)),
        f = y(n(20)),
        h = y(n(21)),
        p = y(n(22)),
        m = n(23),
        g = n(1),
        v = n(0);
      function y(e) {
        return e && e.__esModule ? e : { default: e };
      }
      var w = (function () {
        function e(t) {
          !(function (e, t) {
            if (!(e instanceof t))
              throw new TypeError("Cannot call a class as a function");
          })(this, e);
          var n = {
              animateHistoryBrowsing: !1,
              animationSelector: '[class*="transition-"]',
              linkSelector:
                'a[href^="' +
                window.location.origin +
                '"]:not([data-no-swup]), a[href^="/"]:not([data-no-swup]), a[href^="#"]:not([data-no-swup])',
              cache: !0,
              containers: ["#swup"],
              requestHeaders: {
                "X-Requested-With": "swup",
                Accept: "text/html, application/xhtml+xml",
              },
              plugins: [],
              skipPopStateHandling: function (e) {
                return !(e.state && "swup" === e.state.source);
              },
            },
            r = i({}, n, t);
          (this._handlers = {
            animationInDone: [],
            animationInStart: [],
            animationOutDone: [],
            animationOutStart: [],
            animationSkipped: [],
            clickLink: [],
            contentReplaced: [],
            disabled: [],
            enabled: [],
            openPageInNewTab: [],
            pageLoaded: [],
            pageRetrievedFromCache: [],
            pageView: [],
            popState: [],
            samePage: [],
            samePageWithHash: [],
            serverError: [],
            transitionStart: [],
            transitionEnd: [],
            willReplaceContent: [],
          }),
            (this.scrollToElement = null),
            (this.preloadPromise = null),
            (this.options = r),
            (this.plugins = []),
            (this.transition = {}),
            (this.delegatedListeners = {}),
            (this.boundPopStateHandler = this.popStateHandler.bind(this)),
            (this.cache = new a.default()),
            (this.cache.swup = this),
            (this.loadPage = s.default),
            (this.renderPage = u.default),
            (this.triggerEvent = l.default),
            (this.on = c.default),
            (this.off = d.default),
            (this.updateTransition = f.default),
            (this.getAnimationPromises = h.default),
            (this.getPageData = p.default),
            (this.log = function () {}),
            (this.use = m.use),
            (this.unuse = m.unuse),
            (this.findPlugin = m.findPlugin),
            this.enable();
        }
        return (
          r(e, [
            {
              key: "enable",
              value: function () {
                var e = this;
                if ("undefined" != typeof Promise) {
                  (this.delegatedListeners.click = (0, o.default)(
                    document,
                    this.options.linkSelector,
                    "click",
                    this.linkClickHandler.bind(this)
                  )),
                    window.addEventListener(
                      "popstate",
                      this.boundPopStateHandler
                    );
                  var t = (0, v.getDataFromHtml)(
                    document.documentElement.outerHTML,
                    this.options.containers
                  );
                  (t.url = t.responseURL = (0, v.getCurrentUrl)()),
                    this.options.cache && this.cache.cacheUrl(t),
                    (0, v.markSwupElements)(
                      document.documentElement,
                      this.options.containers
                    ),
                    this.options.plugins.forEach(function (t) {
                      e.use(t);
                    }),
                    window.history.replaceState(
                      Object.assign({}, window.history.state, {
                        url: window.location.href,
                        random: Math.random(),
                        source: "swup",
                      }),
                      document.title,
                      window.location.href
                    ),
                    this.triggerEvent("enabled"),
                    document.documentElement.classList.add("swup-enabled"),
                    this.triggerEvent("pageView");
                } else console.warn("Promise is not supported");
              },
            },
            {
              key: "destroy",
              value: function () {
                var e = this;
                this.delegatedListeners.click.destroy(),
                  window.removeEventListener(
                    "popstate",
                    this.boundPopStateHandler
                  ),
                  this.cache.empty(),
                  this.options.plugins.forEach(function (t) {
                    e.unuse(t);
                  }),
                  (0, g.queryAll)("[data-swup]").forEach(function (e) {
                    e.removeAttribute("data-swup");
                  }),
                  this.off(),
                  this.triggerEvent("disabled"),
                  document.documentElement.classList.remove("swup-enabled");
              },
            },
            {
              key: "linkClickHandler",
              value: function (e) {
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey)
                  this.triggerEvent("openPageInNewTab", e);
                else if (0 === e.button) {
                  this.triggerEvent("clickLink", e), e.preventDefault();
                  var t = new v.Link(e.delegateTarget);
                  if (
                    t.getAddress() == (0, v.getCurrentUrl)() ||
                    "" == t.getAddress()
                  )
                    "" != t.getHash()
                      ? (this.triggerEvent("samePageWithHash", e),
                        null != document.querySelector(t.getHash())
                          ? history.replaceState(
                              {
                                url: t.getAddress() + t.getHash(),
                                random: Math.random(),
                                source: "swup",
                              },
                              document.title,
                              t.getAddress() + t.getHash()
                            )
                          : console.warn(
                              "Element for offset not found (" +
                                t.getHash() +
                                ")"
                            ))
                      : this.triggerEvent("samePage", e);
                  else {
                    "" != t.getHash() && (this.scrollToElement = t.getHash());
                    var n = e.delegateTarget.getAttribute(
                      "data-swup-transition"
                    );
                    this.loadPage(
                      { url: t.getAddress(), customTransition: n },
                      !1
                    );
                  }
                }
              },
            },
            {
              key: "popStateHandler",
              value: function (e) {
                if (!this.options.skipPopStateHandling(e)) {
                  var t = new v.Link(
                    e.state ? e.state.url : window.location.pathname
                  );
                  "" !== t.getHash()
                    ? (this.scrollToElement = t.getHash())
                    : e.preventDefault(),
                    this.triggerEvent("popState", e),
                    this.loadPage({ url: t.getAddress() }, e);
                }
              },
            },
          ]),
          e
        );
      })();
      t.default = w;
    },
    function (e, t, n) {
      var i = n(5);
      e.exports = function (e, t, n, r, o) {
        var a = function (e, t, n, r) {
          return function (n) {
            (n.delegateTarget = i(n.target, t)),
              n.delegateTarget && r.call(e, n);
          };
        }.apply(this, arguments);
        return (
          e.addEventListener(n, a, o),
          {
            destroy: function () {
              e.removeEventListener(n, a, o);
            },
          }
        );
      };
    },
    function (e, t) {
      if ("undefined" != typeof Element && !Element.prototype.matches) {
        var n = Element.prototype;
        n.matches =
          n.matchesSelector ||
          n.mozMatchesSelector ||
          n.msMatchesSelector ||
          n.oMatchesSelector ||
          n.webkitMatchesSelector;
      }
      e.exports = function (e, t) {
        for (; e && 9 !== e.nodeType; ) {
          if ("function" == typeof e.matches && e.matches(t)) return e;
          e = e.parentNode;
        }
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i = (function () {
          function e(e, t) {
            for (var n = 0; n < t.length; n++) {
              var i = t[n];
              (i.enumerable = i.enumerable || !1),
                (i.configurable = !0),
                "value" in i && (i.writable = !0),
                Object.defineProperty(e, i.key, i);
            }
          }
          return function (t, n, i) {
            return n && e(t.prototype, n), i && e(t, i), t;
          };
        })(),
        r = (t.Cache = (function () {
          function e() {
            !(function (e, t) {
              if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
            })(this, e),
              (this.pages = {}),
              (this.last = null);
          }
          return (
            i(e, [
              {
                key: "cacheUrl",
                value: function (e) {
                  e.url in this.pages == 0 && (this.pages[e.url] = e),
                    (this.last = this.pages[e.url]),
                    this.swup.log(
                      "Cache (" + Object.keys(this.pages).length + ")",
                      this.pages
                    );
                },
              },
              {
                key: "getPage",
                value: function (e) {
                  return this.pages[e];
                },
              },
              {
                key: "getCurrentPage",
                value: function () {
                  return this.getPage(
                    window.location.pathname + window.location.search
                  );
                },
              },
              {
                key: "exists",
                value: function (e) {
                  return e in this.pages;
                },
              },
              {
                key: "empty",
                value: function () {
                  (this.pages = {}),
                    (this.last = null),
                    this.swup.log("Cache cleared");
                },
              },
              {
                key: "remove",
                value: function (e) {
                  delete this.pages[e];
                },
              },
            ]),
            e
          );
        })());
      t.default = r;
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i =
          Object.assign ||
          function (e) {
            for (var t = 1; t < arguments.length; t++) {
              var n = arguments[t];
              for (var i in n)
                Object.prototype.hasOwnProperty.call(n, i) && (e[i] = n[i]);
            }
            return e;
          },
        r = n(0);
      t.default = function (e, t) {
        var n = this,
          o = [],
          a = void 0;
        this.triggerEvent("transitionStart", t),
          null != e.customTransition
            ? (this.updateTransition(
                window.location.pathname,
                e.url,
                e.customTransition
              ),
              document.documentElement.classList.add(
                "to-" + (0, r.classify)(e.customTransition)
              ))
            : this.updateTransition(window.location.pathname, e.url),
          !t || this.options.animateHistoryBrowsing
            ? (function () {
                if (
                  (n.triggerEvent("animationOutStart"),
                  document.documentElement.classList.add("is-changing"),
                  document.documentElement.classList.add("is-leaving"),
                  document.documentElement.classList.add("is-animating"),
                  t && document.documentElement.classList.add("is-popstate"),
                  document.documentElement.classList.add(
                    "to-" + (0, r.classify)(e.url)
                  ),
                  (o = n.getAnimationPromises("out")),
                  Promise.all(o).then(function () {
                    n.triggerEvent("animationOutDone");
                  }),
                  !t)
                ) {
                  var i;
                  (i =
                    null != n.scrollToElement
                      ? e.url + n.scrollToElement
                      : e.url),
                    (0, r.createHistoryRecord)(i);
                }
              })()
            : this.triggerEvent("animationSkipped"),
          this.cache.exists(e.url)
            ? ((a = new Promise(function (e) {
                e();
              })),
              this.triggerEvent("pageRetrievedFromCache"))
            : (a =
                this.preloadPromise && this.preloadPromise.route == e.url
                  ? this.preloadPromise
                  : new Promise(function (t, o) {
                      (0,
                      r.fetch)(i({}, e, { headers: n.options.requestHeaders }), function (i) {
                        if (500 === i.status)
                          return n.triggerEvent("serverError"), void o(e.url);
                        var r = n.getPageData(i);
                        null != r
                          ? ((r.url = e.url),
                            n.cache.cacheUrl(r),
                            n.triggerEvent("pageLoaded"),
                            t())
                          : o(e.url);
                      });
                    })),
          document
            .getElementById("preloader")
            .classList.remove("preloader-hide"),
          setTimeout(function () {
            Promise.all(o.concat([a]))
              .then(function () {
                n.renderPage(n.cache.getPage(e.url), t),
                  (n.preloadPromise = null),
                  setTimeout(function () {
                    document
                      .getElementById("preloader")
                      .classList.add("preloader-hide");
                  }, 50);
              })
              .catch(function (e) {
                (n.options.skipPopStateHandling = function () {
                  return (window.location = e), !0;
                }),
                  window.history.go(-1);
              }),
              window.scrollTo(0, 0);
          }, 180);
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e) {
          var t = e
            .toString()
            .toLowerCase()
            .replace(/\s+/g, "-")
            .replace(/\//g, "-")
            .replace(/[^\w\-]+/g, "")
            .replace(/\-\-+/g, "-")
            .replace(/^-+/, "")
            .replace(/-+$/, "");
          return (
            "/" === t[0] && (t = t.splice(1)), "" === t && (t = "homepage"), t
          );
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e) {
          window.history.pushState(
            {
              url: e || window.location.href.split(window.location.hostname)[1],
              random: Math.random(),
              source: "swup",
            },
            document.getElementsByTagName("title")[0].innerText,
            e || window.location.href.split(window.location.hostname)[1]
          );
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i =
          "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
            ? function (e) {
                return typeof e;
              }
            : function (e) {
                return e &&
                  "function" == typeof Symbol &&
                  e.constructor === Symbol &&
                  e !== Symbol.prototype
                  ? "symbol"
                  : typeof e;
              },
        r = n(1);
      t.default = function (e, t) {
        var n = document.createElement("html");
        n.innerHTML = e;
        for (
          var o = [],
            a = function (e) {
              if (null == n.querySelector(t[e])) return { v: null };
              (0, r.queryAll)(t[e]).forEach(function (i, a) {
                (0, r.queryAll)(t[e], n)[a].setAttribute("data-swup", o.length),
                  o.push((0, r.queryAll)(t[e], n)[a].outerHTML);
              });
            },
            s = 0;
          s < t.length;
          s++
        ) {
          var u = a(s);
          if ("object" === (void 0 === u ? "undefined" : i(u))) return u.v;
        }
        var l = {
          title: n.querySelector("title").innerText,
          pageClass: n.querySelector("body").className,
          originalContent: e,
          blocks: o,
        };
        return (n.innerHTML = ""), (n = null), l;
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i =
        Object.assign ||
        function (e) {
          for (var t = 1; t < arguments.length; t++) {
            var n = arguments[t];
            for (var i in n)
              Object.prototype.hasOwnProperty.call(n, i) && (e[i] = n[i]);
          }
          return e;
        };
      t.default = function (e) {
        var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1],
          n = {
            url: window.location.pathname + window.location.search,
            method: "GET",
            data: null,
            headers: {},
          },
          r = i({}, n, e),
          o = new XMLHttpRequest();
        return (
          (o.onreadystatechange = function () {
            4 === o.readyState && (o.status, t(o));
          }),
          o.open(r.method, r.url, !0),
          Object.keys(r.headers).forEach(function (e) {
            o.setRequestHeader(e, r.headers[e]);
          }),
          o.send(r.data),
          o
        );
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function () {
          var e = document.createElement("div"),
            t = {
              WebkitTransition: "webkitTransitionEnd",
              MozTransition: "transitionend",
              OTransition: "oTransitionEnd otransitionend",
              transition: "transitionend",
            };
          for (var n in t) if (void 0 !== e.style[n]) return t[n];
          return !1;
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function () {
          return window.location.pathname + window.location.search;
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i = n(1);
      t.default = function (e, t) {
        for (
          var n = 0,
            r = function (r) {
              null == e.querySelector(t[r])
                ? console.warn("Element " + t[r] + " is not in current page.")
                : (0, i.queryAll)(t[r]).forEach(function (o, a) {
                    (0, i.queryAll)(t[r], e)[a].setAttribute("data-swup", n),
                      n++;
                  });
            },
            o = 0;
          o < t.length;
          o++
        )
          r(o);
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i = (function () {
          function e(e, t) {
            for (var n = 0; n < t.length; n++) {
              var i = t[n];
              (i.enumerable = i.enumerable || !1),
                (i.configurable = !0),
                "value" in i && (i.writable = !0),
                Object.defineProperty(e, i.key, i);
            }
          }
          return function (t, n, i) {
            return n && e(t.prototype, n), i && e(t, i), t;
          };
        })(),
        r = (function () {
          function e(t) {
            !(function (e, t) {
              if (!(e instanceof t))
                throw new TypeError("Cannot call a class as a function");
            })(this, e),
              t instanceof Element || t instanceof SVGElement
                ? (this.link = t)
                : ((this.link = document.createElement("a")),
                  (this.link.href = t));
          }
          return (
            i(e, [
              {
                key: "getPath",
                value: function () {
                  var e = this.link.pathname;
                  return "/" !== e[0] && (e = "/" + e), e;
                },
              },
              {
                key: "getAddress",
                value: function () {
                  var e = this.link.pathname + this.link.search;
                  return (
                    this.link.getAttribute("xlink:href") &&
                      (e = this.link.getAttribute("xlink:href")),
                    "/" !== e[0] && (e = "/" + e),
                    e
                  );
                },
              },
              {
                key: "getHash",
                value: function () {
                  return this.link.hash;
                },
              },
            ]),
            e
          );
        })();
      t.default = r;
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i =
          Object.assign ||
          function (e) {
            for (var t = 1; t < arguments.length; t++) {
              var n = arguments[t];
              for (var i in n)
                Object.prototype.hasOwnProperty.call(n, i) && (e[i] = n[i]);
            }
            return e;
          },
        r = (n(1), n(0));
      t.default = function (e, t) {
        var n = this;
        document.documentElement.classList.remove("is-leaving");
        var o = new r.Link(e.responseURL);
        window.location.pathname !== o.getPath() &&
          (window.history.replaceState(
            { url: o.getPath(), random: Math.random(), source: "swup" },
            document.title,
            o.getPath()
          ),
          this.cache.cacheUrl(i({}, e, { url: o.getPath() }))),
          (t && !this.options.animateHistoryBrowsing) ||
            document.documentElement.classList.add("is-rendering"),
          this.triggerEvent("willReplaceContent", t);
        for (var a = 0; a < e.blocks.length; a++)
          document.body.querySelector('[data-swup="' + a + '"]').outerHTML =
            e.blocks[a];
        if (
          ((document.title = e.title),
          this.triggerEvent("contentReplaced", t),
          this.triggerEvent("pageView", t),
          this.options.cache || this.cache.empty(),
          setTimeout(function () {
            (t && !n.options.animateHistoryBrowsing) ||
              (n.triggerEvent("animationInStart"),
              document.documentElement.classList.remove("is-animating"));
          }, 10),
          !t || this.options.animateHistoryBrowsing)
        ) {
          var s = this.getAnimationPromises("in");
          Promise.all(s).then(function () {
            n.triggerEvent("animationInDone"),
              n.triggerEvent("transitionEnd", t),
              document.documentElement.className
                .split(" ")
                .forEach(function (e) {
                  (new RegExp("^to-").test(e) ||
                    "is-changing" === e ||
                    "is-rendering" === e ||
                    "is-popstate" === e) &&
                    document.documentElement.classList.remove(e);
                });
          });
        } else this.triggerEvent("transitionEnd", t);
        this.scrollToElement = null;
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e, t) {
          this._handlers[e].forEach(function (e) {
            try {
              e(t);
            } catch (e) {
              console.error(e);
            }
          });
          var n = new CustomEvent("swup:" + e, { detail: e });
          document.dispatchEvent(n);
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e, t) {
          this._handlers[e]
            ? this._handlers[e].push(t)
            : console.warn("Unsupported event " + e + ".");
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e, t) {
          var n = this;
          if (null != e)
            if (null != t)
              if (
                this._handlers[e] &&
                this._handlers[e].filter(function (e) {
                  return e === t;
                }).length
              ) {
                var i = this._handlers[e].filter(function (e) {
                    return e === t;
                  })[0],
                  r = this._handlers[e].indexOf(i);
                r > -1 && this._handlers[e].splice(r, 1);
              } else console.warn("Handler for event '" + e + "' no found.");
            else this._handlers[e] = [];
          else
            Object.keys(this._handlers).forEach(function (e) {
              n._handlers[e] = [];
            });
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.default = function (e, t, n) {
          this.transition = { from: e, to: t, custom: n };
        });
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i = n(1),
        r = n(0);
      t.default = function () {
        var e = [];
        return (
          (0, i.queryAll)(this.options.animationSelector).forEach(function (t) {
            var n = new Promise(function (e) {
              t.addEventListener((0, r.transitionEnd)(), function (n) {
                t == n.target && e();
              });
            });
            e.push(n);
          }),
          e
        );
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 });
      var i = n(0);
      t.default = function (e) {
        var t = e.responseText,
          n = (0, i.getDataFromHtml)(t, this.options.containers);
        return n
          ? ((n.responseURL = e.responseURL
              ? e.responseURL
              : window.location.href),
            n)
          : (console.warn(
              "The link you are hovering over does not exist (404 ERROR) Please make sure your link is pointing to a valid location."
            ),
            null);
      };
    },
    function (e, t, n) {
      "use strict";
      Object.defineProperty(t, "__esModule", { value: !0 }),
        (t.use = function (e) {
          if (e.isSwupPlugin)
            return (
              this.plugins.push(e),
              (e.swup = this),
              "function" == typeof e._beforeMount && e._beforeMount(),
              e.mount(),
              this.plugins
            );
          console.warn("Not swup plugin instance " + e + ".");
        }),
        (t.unuse = function (e) {
          var t = void 0;
          if (
            (t =
              "string" == typeof e
                ? this.plugins.find(function (t) {
                    return e === t.name;
                  })
                : e)
          ) {
            t.unmount(),
              "function" == typeof t._afterUnmount && t._afterUnmount();
            var n = this.plugins.indexOf(t);
            return this.plugins.splice(n, 1), this.plugins;
          }
          console.warn("No such plugin.");
        }),
        (t.findPlugin = function (e) {
          return this.plugins.find(function (t) {
            return e === t.name;
          });
        });
    },
  ]);
});

/*Enabled AJAX Custom Preload SWUP Function*/
(function e(t, r) {
  if (typeof exports === "object" && typeof module === "object")
    module.exports = r();
  else if (typeof define === "function" && define.amd) define([], r);
  else if (typeof exports === "object") exports["SwupPreloadPlugin"] = r();
  else t["SwupPreloadPlugin"] = r();
})(window, function () {
  return (function (e) {
    var t = {};
    function r(n) {
      if (t[n]) {
        return t[n].exports;
      }
      var o = (t[n] = {
        i: n,
        l: false,
        exports: {},
      });
      e[n].call(o.exports, o, o.exports, r);
      o.l = true;
      return o.exports;
    }
    r.m = e;
    r.c = t;
    r.d = function (e, t, n) {
      if (!r.o(e, t)) {
        Object.defineProperty(e, t, {
          enumerable: true,
          get: n,
        });
      }
    };
    r.r = function (e) {
      if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
        Object.defineProperty(e, Symbol.toStringTag, {
          value: "Module",
        });
      }
      Object.defineProperty(e, "__esModule", {
        value: true,
      });
    };
    r.t = function (e, t) {
      if (t & 1) e = r(e);
      if (t & 8) return e;
      if (t & 4 && typeof e === "object" && e && e.__esModule) return e;
      var n = Object.create(null);
      r.r(n);
      Object.defineProperty(n, "default", {
        enumerable: true,
        value: e,
      });
      if (t & 2 && typeof e != "string")
        for (var o in e)
          r.d(
            n,
            o,
            function (t) {
              return e[t];
            }.bind(null, o)
          );
      return n;
    };
    r.n = function (e) {
      var t =
        e && e.__esModule
          ? function t() {
              return e["default"];
            }
          : function t() {
              return e;
            };
      r.d(t, "a", t);
      return t;
    };
    r.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    };
    r.p = "";
    return r((r.s = 1));
  })([
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = (t.query = function e(t) {
        var r =
          arguments.length > 1 && arguments[1] !== undefined
            ? arguments[1]
            : document;
        if (typeof t !== "string") {
          return t;
        }
        return r.querySelector(t);
      });
      var o = (t.queryAll = function e(t) {
        var r =
          arguments.length > 1 && arguments[1] !== undefined
            ? arguments[1]
            : document;
        if (typeof t !== "string") {
          return t;
        }
        return Array.prototype.slice.call(r.querySelectorAll(t));
      });
    },
    function (e, t, r) {
      "use strict";
      var n = r(2);
      var o = a(n);
      function a(e) {
        return e && e.__esModule
          ? e
          : {
              default: e,
            };
      }
      e.exports = o.default;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = (function () {
        function e(e, t) {
          for (var r = 0; r < t.length; r++) {
            var n = t[r];
            n.enumerable = n.enumerable || false;
            n.configurable = true;
            if ("value" in n) n.writable = true;
            Object.defineProperty(e, n.key, n);
          }
        }
        return function (t, r, n) {
          if (r) e(t.prototype, r);
          if (n) e(t, n);
          return t;
        };
      })();
      var o = r(3);
      var a = s(o);
      var u = r(4);
      var i = s(u);
      var l = r(0);
      var f = r(6);
      function s(e) {
        return e && e.__esModule
          ? e
          : {
              default: e,
            };
      }
      function c(e, t) {
        if (!(e instanceof t)) {
          throw new TypeError("Cannot call a class as a function");
        }
      }
      function d(e, t) {
        if (!e) {
          throw new ReferenceError(
            "this hasn't been initialised - super() hasn't been called"
          );
        }
        return t && (typeof t === "object" || typeof t === "function") ? t : e;
      }
      function p(e, t) {
        if (typeof t !== "function" && t !== null) {
          throw new TypeError(
            "Super expression must either be null or a function, not " +
              typeof t
          );
        }
        e.prototype = Object.create(t && t.prototype, {
          constructor: {
            value: e,
            enumerable: false,
            writable: true,
            configurable: true,
          },
        });
        if (t)
          Object.setPrototypeOf
            ? Object.setPrototypeOf(e, t)
            : (e.__proto__ = t);
      }
      var v = (function (e) {
        p(t, e);
        function t() {
          var e;
          var r, n, o;
          c(this, t);
          for (var a = arguments.length, u = Array(a), i = 0; i < a; i++) {
            u[i] = arguments[i];
          }
          return (
            (o =
              ((r =
                ((n = d(
                  this,
                  (e = t.__proto__ || Object.getPrototypeOf(t)).call.apply(
                    e,
                    [this].concat(u)
                  )
                )),
                n)),
              (n.name = "PreloadPlugin"),
              (n.onContentReplaced = function () {
                n.swup.preloadPages();
              }),
              (n.onMouseover = function (e) {
                var t = n.swup;
                t.triggerEvent("hoverLink", e);
                var r = new f.Link(e.delegateTarget);
                if (
                  r.getAddress() !== (0, f.getCurrentUrl)() &&
                  !t.cache.exists(r.getAddress()) &&
                  t.preloadPromise == null
                ) {
                  t.preloadPromise = t.preloadPage(r.getAddress());
                  t.preloadPromise.route = r.getAddress();
                  t.preloadPromise.finally(function () {
                    t.preloadPromise = null;
                  });
                }
              }),
              (n.preloadPage = function (e) {
                var t = n.swup;
                var r = new f.Link(e);
                return new Promise(function (e, n) {
                  if (
                    r.getAddress() != (0, f.getCurrentUrl)() &&
                    !t.cache.exists(r.getAddress())
                  ) {
                    (0, f.fetch)(
                      {
                        url: r.getAddress(),
                        headers: t.options.requestHeaders,
                      },
                      function (o) {
                        if (o.status === 500) {
                          t.triggerEvent("serverError");
                          n();
                        } else {
                          var a = t.getPageData(o);
                          if (a != null) {
                            a.url = r.getAddress();
                            t.cache.cacheUrl(a, t.options.debugMode);
                            t.triggerEvent("pagePreloaded");
                          } else {
                            n(r.getAddress());
                            return;
                          }
                          e(t.cache.getPage(r.getAddress()));
                        }
                      }
                    );
                  } else {
                    e(t.cache.getPage(r.getAddress()));
                  }
                });
              }),
              (n.preloadPages = function () {
                (0, l.queryAll)("[data-swup-preload]").forEach(function (e) {
                  n.swup.preloadPage(e.href);
                });
              }),
              r)),
            d(n, o)
          );
        }
        n(t, [
          {
            key: "mount",
            value: function e() {
              var t = this.swup;
              t._handlers.pagePreloaded = [];
              t._handlers.hoverLink = [];
              t.preloadPage = this.preloadPage;
              t.preloadPages = this.preloadPages;
              t.delegatedListeners.mouseover = (0, i.default)(
                document.body,
                t.options.linkSelector,
                "mouseover",
                this.onMouseover.bind(this)
              );
              t.preloadPages();
              t.on("contentReplaced", this.onContentReplaced);
            },
          },
          {
            key: "unmount",
            value: function e() {
              var t = this.swup;
              t._handlers.pagePreloaded = null;
              t._handlers.hoverLink = null;
              t.preloadPage = null;
              t.preloadPages = null;
              t.delegatedListeners.mouseover.destroy();
              t.off("contentReplaced", this.onContentReplaced);
            },
          },
        ]);
        return t;
      })(a.default);
      t.default = v;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = (function () {
        function e(e, t) {
          for (var r = 0; r < t.length; r++) {
            var n = t[r];
            n.enumerable = n.enumerable || false;
            n.configurable = true;
            if ("value" in n) n.writable = true;
            Object.defineProperty(e, n.key, n);
          }
        }
        return function (t, r, n) {
          if (r) e(t.prototype, r);
          if (n) e(t, n);
          return t;
        };
      })();
      function o(e, t) {
        if (!(e instanceof t)) {
          throw new TypeError("Cannot call a class as a function");
        }
      }
      var a = (function () {
        function e() {
          o(this, e);
          this.isSwupPlugin = true;
        }
        n(e, [
          {
            key: "mount",
            value: function e() {},
          },
          {
            key: "unmount",
            value: function e() {},
          },
          {
            key: "_beforeMount",
            value: function e() {},
          },
          {
            key: "_afterUnmount",
            value: function e() {},
          },
        ]);
        return e;
      })();
      t.default = a;
    },
    function (e, t, r) {
      var n = r(5);
      function o(e, t, r, n, o) {
        var a = u.apply(this, arguments);
        e.addEventListener(r, a, o);
        return {
          destroy: function () {
            e.removeEventListener(r, a, o);
          },
        };
      }
      function a(e, t, r, n, a) {
        if (typeof e.addEventListener === "function") {
          return o.apply(null, arguments);
        }
        if (typeof r === "function") {
          return o.bind(null, document).apply(null, arguments);
        }
        if (typeof e === "string") {
          e = document.querySelectorAll(e);
        }
        return Array.prototype.map.call(e, function (e) {
          return o(e, t, r, n, a);
        });
      }
      function u(e, t, r, o) {
        return function (r) {
          r.delegateTarget = n(r.target, t);
          if (r.delegateTarget) {
            o.call(e, r);
          }
        };
      }
      e.exports = a;
    },
    function (e, t) {
      var r = 9;
      if (typeof Element !== "undefined" && !Element.prototype.matches) {
        var n = Element.prototype;
        n.matches =
          n.matchesSelector ||
          n.mozMatchesSelector ||
          n.msMatchesSelector ||
          n.oMatchesSelector ||
          n.webkitMatchesSelector;
      }
      function o(e, t) {
        while (e && e.nodeType !== r) {
          if (typeof e.matches === "function" && e.matches(t)) {
            return e;
          }
          e = e.parentNode;
        }
      }
      e.exports = o;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      t.Link =
        t.markSwupElements =
        t.getCurrentUrl =
        t.transitionEnd =
        t.fetch =
        t.getDataFromHTML =
        t.createHistoryRecord =
        t.classify =
          undefined;
      var n = r(7);
      var o = b(n);
      var a = r(8);
      var u = b(a);
      var i = r(9);
      var l = b(i);
      var f = r(10);
      var s = b(f);
      var c = r(11);
      var d = b(c);
      var p = r(12);
      var v = b(p);
      var y = r(13);
      var h = b(y);
      var g = r(14);
      var m = b(g);
      function b(e) {
        return e && e.__esModule
          ? e
          : {
              default: e,
            };
      }
      var w = (t.classify = o.default);
      var P = (t.createHistoryRecord = u.default);
      var _ = (t.getDataFromHTML = l.default);
      var k = (t.fetch = s.default);
      var M = (t.transitionEnd = d.default);
      var j = (t.getCurrentUrl = v.default);
      var O = (t.markSwupElements = h.default);
      var E = (t.Link = m.default);
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = function e(t) {
        var r = t
          .toString()
          .toLowerCase()
          .replace(/\s+/g, "-")
          .replace(/\//g, "-")
          .replace(/[^\w\-]+/g, "")
          .replace(/\-\-+/g, "-")
          .replace(/^-+/, "")
          .replace(/-+$/, "");
        if (r[0] === "/") r = r.splice(1);
        if (r === "") r = "homepage";
        return r;
      };
      t.default = n;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = function e(t) {
        window.history.pushState(
          {
            url: t || window.location.href.split(window.location.hostname)[1],
            random: Math.random(),
            source: "swup",
          },
          document.getElementsByTagName("title")[0].innerText,
          t || window.location.href.split(window.location.hostname)[1]
        );
      };
      t.default = n;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n =
        typeof Symbol === "function" && typeof Symbol.iterator === "symbol"
          ? function (e) {
              return typeof e;
            }
          : function (e) {
              return e &&
                typeof Symbol === "function" &&
                e.constructor === Symbol &&
                e !== Symbol.prototype
                ? "symbol"
                : typeof e;
            };
      var o = r(0);
      var a = function e(t, r) {
        var a = t
          .replace("<body", '<div id="swupBody"')
          .replace("</body>", "</div>");
        var u = document.createElement("div");
        u.innerHTML = a;
        var i = [];
        var l = function e(t) {
          if (u.querySelector(r[t]) == null) {
            return {
              v: null,
            };
          } else {
            (0, o.queryAll)(r[t]).forEach(function (e, n) {
              (0, o.queryAll)(r[t], u)[n].dataset.swup = i.length;
              i.push((0, o.queryAll)(r[t], u)[n].outerHTML);
            });
          }
        };
        for (var f = 0; f < r.length; f++) {
          var s = l(f);
          if ((typeof s === "undefined" ? "undefined" : n(s)) === "object")
            return s.v;
        }
        var c = {
          title: u.querySelector("title").innerText,
          pageClass: u.querySelector("#swupBody").className,
          originalContent: t,
          blocks: i,
        };
        u.innerHTML = "";
        u = null;
        return c;
      };
      t.default = a;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n =
        Object.assign ||
        function (e) {
          for (var t = 1; t < arguments.length; t++) {
            var r = arguments[t];
            for (var n in r) {
              if (Object.prototype.hasOwnProperty.call(r, n)) {
                e[n] = r[n];
              }
            }
          }
          return e;
        };
      var o = function e(t) {
        var r =
          arguments.length > 1 && arguments[1] !== undefined
            ? arguments[1]
            : false;
        var o = {
          url: window.location.pathname + window.location.search,
          method: "GET",
          data: null,
          headers: {},
        };
        var a = n({}, o, t);
        var u = new XMLHttpRequest();
        u.onreadystatechange = function () {
          if (u.readyState === 4) {
            if (u.status !== 500) {
              r(u);
            } else {
              r(u);
            }
          }
        };
        u.open(a.method, a.url, true);
        Object.keys(a.headers).forEach(function (e) {
          u.setRequestHeader(e, a.headers[e]);
        });
        u.send(a.data);
        return u;
      };
      t.default = o;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = function e() {
        var t = document.createElement("div");
        var r = {
          WebkitTransition: "webkitTransitionEnd",
          MozTransition: "transitionend",
          OTransition: "oTransitionEnd otransitionend",
          transition: "transitionend",
        };
        for (var n in r) {
          if (t.style[n] !== undefined) {
            return r[n];
          }
        }
        return false;
      };
      t.default = n;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = function e() {
        return window.location.pathname + window.location.search;
      };
      t.default = n;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = r(0);
      var o = function e(t, r) {
        var o = 0;
        var a = function e(a) {
          if (t.querySelector(r[a]) == null) {
            console.warn("Element " + r[a] + " is not in current page.");
          } else {
            (0, n.queryAll)(r[a]).forEach(function (e, u) {
              (0, n.queryAll)(r[a], t)[u].dataset.swup = o;
              o++;
            });
          }
        };
        for (var u = 0; u < r.length; u++) {
          a(u);
        }
      };
      t.default = o;
    },
    function (e, t, r) {
      "use strict";
      Object.defineProperty(t, "__esModule", {
        value: true,
      });
      var n = (function () {
        function e(e, t) {
          for (var r = 0; r < t.length; r++) {
            var n = t[r];
            n.enumerable = n.enumerable || false;
            n.configurable = true;
            if ("value" in n) n.writable = true;
            Object.defineProperty(e, n.key, n);
          }
        }
        return function (t, r, n) {
          if (r) e(t.prototype, r);
          if (n) e(t, n);
          return t;
        };
      })();
      function o(e, t) {
        if (!(e instanceof t)) {
          throw new TypeError("Cannot call a class as a function");
        }
      }
      var a = (function () {
        function e(t) {
          o(this, e);
          if (t instanceof Element || t instanceof SVGElement) {
            this.link = t;
          } else {
            this.link = document.createElement("a");
            this.link.href = t;
          }
        }
        n(e, [
          {
            key: "getPath",
            value: function e() {
              var t = this.link.pathname;
              if (t[0] !== "/") {
                t = "/" + t;
              }
              return t;
            },
          },
          {
            key: "getAddress",
            value: function e() {
              var t = this.link.pathname + this.link.search;
              if (this.link.getAttribute("xlink:href")) {
                t = this.link.getAttribute("xlink:href");
              }
              if (t[0] !== "/") {
                t = "/" + t;
              }
              return t;
            },
          },
          {
            key: "getHash",
            value: function e() {
              return this.link.hash;
            },
          },
        ]);
        return e;
      })();
      t.default = a;
    },
  ]);
});
